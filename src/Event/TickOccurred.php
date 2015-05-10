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

use Prooph\Common\Messaging\DomainEvent;

/**
 * Class TickOccurred
 *
 * This event signals that a tick occurred It tick is triggered from the client ot indicate
 * that components like registered message dispatchers, workflow processor
 * and so on should perform their next task.
 *
 * @package Prooph\Link\Application\Event
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class TickOccurred extends DomainEvent
{
    /**
     * @return TickOccurred
     */
    public static function record()
    {
        return new self(__CLASS__);
    }
}