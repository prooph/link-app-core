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
use Prooph\Link\Application\Service\TransactionCommand;
use Prooph\ServiceBus\Process\CommandDispatch;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

/**
 * EventStoreTransactionManager Prooph Service Bus Plugin
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
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    /**
     * Attaches itself to the command dispatch of the appliaction command bus
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

    public function onInitialize(CommandDispatch $event)
    {
        if ($event->getCommand() instanceof TransactionCommand) {
            $this->eventStore->beginTransaction();
            $this->inTransaction = true;
        }
    }

    public function onError(CommandDispatch $event)
    {
        if (! $this->inTransaction) return;

        $this->eventStore->rollback();
        $this->inTransaction = false;
    }

    public function onFinalize(CommandDispatch $event)
    {
        if (! $this->inTransaction) return;

        $this->eventStore->commit();
    }
}