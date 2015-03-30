<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/30/15 - 12:54 AM
 */
namespace Prooph\Link\Application\ProophPlugin;


use Prooph\EventSourcing\DomainEvent;
use Prooph\ServiceBus\InvokeStrategy\OnEventStrategy;

final class OnDomainEventInvokeStrategy extends OnEventStrategy
{

    /**
     * @param mixed $aHandler
     * @param mixed $aCommandOrEvent
     * @return bool
     */
    public function canInvoke($aHandler, $aCommandOrEvent)
    {
        if (! $aCommandOrEvent instanceof DomainEvent) {
            return false;
        }

        $handleMethod = 'on' . $this->determineEventName($aCommandOrEvent);

        return method_exists($aHandler, $handleMethod);
    }
}