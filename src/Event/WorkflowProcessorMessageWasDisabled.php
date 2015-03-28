<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/28/15 - 10:59 PM
 */
namespace Prooph\Link\Application\Event;

/**
 * Event WorkflowProcessorMessageWasDisabled
 *
 * @package Prooph\Link\Application\Event
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class WorkflowProcessorMessageWasDisabled extends SystemChanged
{
    /**
     * @return WorkflowProcessorMessageWasDisabled
     */
    public static function record()
    {
        return self::occur([]);
    }
} 