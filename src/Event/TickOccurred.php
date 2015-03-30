<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/27/15 - 10:19 PM
 */
namespace Prooph\Link\Application\Event;

use Prooph\EventSourcing\DomainEvent;
use Prooph\ServiceBus\Message\MessageNameProvider;
use Rhumsaa\Uuid\Uuid;

/**
 * Class TickOccurred
 *
 * This event signals that a tick occurred It tick is triggered from the client ot indicate
 * that components like registered message dispatchers, workflow processor
 * and so on should perform their next task.
 *
 * @package Prooph\Link\Application\Event
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class TickOccurred implements DomainEvent, MessageNameProvider
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @param Uuid $uuid
     * @param \DateTime $occurredOn
     */
    public function __construct(Uuid $uuid = null, \DateTime $occurredOn = null)
    {
        if (is_null($uuid)) {
            $uuid = Uuid::uuid4();
        }

        if (is_null($occurredOn)) {
            $occurredOn = new \DateTime();
        }

        $this->uuid = $uuid;
        $this->occurredOn = $occurredOn;
    }


    /**
     * @return Uuid
     */
    public function uuid()
    {
        return $this->uuid;
    }

    /**
     * @return \DateTime
     */
    public function occurredOn()
    {
        return $this->occurredOn;
    }

    /**
     * @return array
     */
    public function payload()
    {
        return [];
    }

    /**
     * @return string Name of the message
     */
    public function getMessageName()
    {
        return __CLASS__;
    }
}