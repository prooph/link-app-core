<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/28/15 - 10:57 PM
 */
namespace Prooph\Link\Application\Event;

/**
 * Event WorkflowProcessorMessageQueueWasEnabled
 *
 * @package Prooph\Link\Application\Event
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class WorkflowProcessorMessageQueueWasEnabled extends SystemChanged
{
    /**
     * @return WorkflowProcessorMessageQueueWasEnabled
     */
    public static function record()
    {
        return self::occur([]);
    }
} 