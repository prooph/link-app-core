<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/16/15 - 9:26 PM
 */
namespace Prooph\Link\Application\ProophPlugin;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\EventStoreIntegration\AggregateChangedEventHydrator;
use Prooph\EventStore\Stream\StreamEvent;
use Prooph\Link\Application\Service\TransactionEvent;
use Prooph\Link\Application\Service\TransactionId;

/**
 * Class TransactionAwareAggregateChangedEventHydrator
 *
 * @package Prooph\Link\Application\ProophPlugin
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TransactionAwareAggregateChangedEventHydrator extends AggregateChangedEventHydrator
{
    /**
     * @param StreamEvent $streamEvent
     * @return AggregateChanged
     * @throws \RuntimeException if construction fails
     */
    protected function translateToAggregateChangedEvent(StreamEvent $streamEvent)
    {
        $domainEvent = parent::translateToAggregateChangedEvent($streamEvent);

        if ($domainEvent instanceof TransactionEvent) {
            $metadata = $streamEvent->metadata();

            if (isset($metadata['transaction_id'])) {
                $domainEvent->setTransactionId(TransactionId::fromString($metadata['transaction_id']));
            }
        }

        return $domainEvent;
    }
} 