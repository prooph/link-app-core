<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 09.12.14 - 19:45
 */

namespace Prooph\Link\Application\Event;

use Codeliner\ArrayReader\ArrayReader;
use Prooph\Common\Messaging\DomainEvent;
use Rhumsaa\Uuid\Uuid;

/**
 * Event SystemChanged
 *
 * Basic domain event implementation for all events that represent a change in the system that is not related
 * to a specific aggregate. Event sourced aggregates record their own type of event (Prooph\EventSourcing\AggregateChanged)
 *
 * @package Application\Event
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class SystemChanged extends DomainEvent
{
    /**
     * @var Uuid
     */
    protected $uuid;

    /**
     * This property is injected via Reflection
     *
     * @var int
     */
    protected $version;

    /**
     * @var array
     */
    protected $payload;

    /**
     * @var \DateTime
     */
    protected $occurredOn;

    /**
     * @var ArrayReader
     */
    private $payloadReader;

    /**
     * @param array $payload
     * @return static
     */
    public static function occur(array $payload)
    {
        return new static(get_called_class(), $payload);
    }

    /**
     * @return Uuid
     */
    public function uuid()
    {
        return $this->uuid;
    }

    /**
     * @return array
     */
    public function payload()
    {
        return $this->payload;
    }

    /**
     * @return ArrayReader
     */
    public function toPayloadReader()
    {
        if (is_null($this->payloadReader)) {
            $this->payloadReader = new ArrayReader($this->payload());
        }

        return $this->payloadReader;
    }
}
 