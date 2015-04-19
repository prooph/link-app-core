<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/4/15 - 12:25 AM
 */
namespace Prooph\Link\Application\ProophPlugin;

use Prooph\EventStore\EventStore;
use Prooph\EventStore\PersistenceEvent\PreCommitEvent;
use Prooph\Link\Application\Service\TransactionCommand;
use Prooph\Link\Application\Service\TransactionEvent;
use Prooph\Link\Application\Service\TransactionId;
use Prooph\ServiceBus\Process\CommandDispatch;
use Prooph\ServiceBus\Process\EventDispatch;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;

/**
 * EventStoreTransactionManager Prooph Service Bus Plugin
 *
 * The transaction manager starts a new transaction when it detects a TransactionCommand on the command bus.
 * If the command dispatch finishes without an error the transaction manager commits the transaction otherwise it do a rollback.
 * Furthermore it attaches a listener to the event store commit.pre event with a low priority to check if
 * TransactionEvents are going to be committed. If so the transaction manager passes the current TransactionId
 * to each event so that they can be collated to the transaction.
 *
 * @package Prooph\Link\Application\ProophPlugin
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class EventStoreTransactionManager extends AbstractListenerAggregate
{
    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * @var bool
     */
    private $inTransaction = false;

    /**
     * @var TransactionId
     */
    private $currentTransactionId;

    /**
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
        $this->eventStore->getPersistenceEvents()->attach('appendTo.pre', [$this, 'onEventStoreAppendToStream'], -1000);
    }

    /**
     * Attaches itself to the command and event dispatch of the application service bus
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(CommandDispatch::INITIALIZE, [$this, 'onInitialize']);
        $this->listeners[] = $events->attach(CommandDispatch::HANDLE_ERROR, [$this, 'onError']);
        $this->listeners[] = $events->attach(CommandDispatch::FINALIZE, [$this, 'onFinalize']);
    }

    /**
     * @param CommandDispatch $commandDispatch
     */
    public function onInitialize(CommandDispatch $commandDispatch)
    {
        $command = $commandDispatch->getCommand();
        if ($command instanceof TransactionCommand) {
            $this->eventStore->beginTransaction();
            $this->inTransaction = true;
            $this->currentTransactionId = $command->transactionId();
        }
    }

    public function onError(CommandDispatch $commandDispatch)
    {
        if (! $commandDispatch->getCommand() instanceof TransactionCommand) return;
        if (! $this->inTransaction) return;

        $this->eventStore->rollback();
        $this->inTransaction = false;
        $this->currentTransactionId = null;
    }

    public function onFinalize(CommandDispatch $commandDispatch)
    {
        if (! $commandDispatch->getCommand() instanceof TransactionCommand) return;
        if (! $this->inTransaction) return;

        $this->eventStore->commit();
        $this->currentTransactionId = null;
    }

    /**
     * @param Event $appendToStreamEvent
     */
    public function onEventStoreAppendToStream(Event $appendToStreamEvent)
    {
        foreach($appendToStreamEvent->getParam('streamEvents') as $recordedEvent) {
            $recordedEvent->setMetadataEntry('transaction_id', $this->currentTransactionId->toString());
        }
    }
}