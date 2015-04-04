<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/4/15 - 3:27 PM
 */
namespace Prooph\Link\Application\ProophPlugin;

use Prooph\EventSourcing\DomainEvent;
use Prooph\EventSourcing\EventStoreIntegration\EventHydratorInterface;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\Feature\FeatureInterface;
use Prooph\EventStore\PersistenceEvent\PostCommitEvent;
use Prooph\ServiceBus\EventBus;
use Prooph\ServiceBus\Process\EventDispatch;

/**
 * Class RecordedEventsDispatcher
 *
 * @package Prooph\Link\Application\ProophPlugin
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class RecordedEventsDispatcher implements FeatureInterface
{
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @var EventHydratorInterface
     */
    private $eventHydrator;

    /**
     * @param EventBus $eventBus
     * @param EventHydratorInterface $eventHydrator
     */
    public function __construct(EventBus $eventBus, EventHydratorInterface $eventHydrator)
    {
        $this->eventBus = $eventBus;
        $this->eventBus->on(EventDispatch::DETECT_MESSAGE_NAME, [$this, 'onDetectMessageName']);
        $this->eventHydrator = $eventHydrator;
    }
    /**
     * @param EventStore $eventStore
     * @return void
     */
    public function setUp(EventStore $eventStore)
    {
        $eventStore->getPersistenceEvents()->attach('commit.post', [$this, 'onEventStoreCommitPost']);
    }

    public function onEventStoreCommitPost(PostCommitEvent $event)
    {
        $domainEvents = $this->eventHydrator->toAggregateChangedEvents($event->getRecordedEvents());

        foreach($domainEvents as $domainEvent) {
            $this->eventBus->dispatch($domainEvent);
        }
    }

    /**
     * @param EventDispatch $event
     */
    public function onDetectMessageName(EventDispatch $event)
    {
        if ($event->getEvent() instanceof DomainEvent) {
            $event->setMessageName(get_class($event->getEvent()));
        }
    }
}