<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/28/15 - 11:07 PM
 */
namespace Prooph\Link\Application\Command;

use Prooph\Link\Application\SharedKernel\ConfigLocation;

/**
 * Command DisableWorkflowProcessorMessageQueue
 *
 * @package Prooph\Link\Application\Command
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class DisableWorkflowProcessorMessageQueue extends SystemCommand
{
    /**
     * @param ConfigLocation $configLocation
     * @return EnableWorkflowProcessorMessageQueue
     */
    public static function in(ConfigLocation $configLocation)
    {
        return new self(__CLASS__, ['config_location' => $configLocation->toString()]);
    }

    protected function assertPayload($aPayload = null)
    {
        //nothing to do here
    }
} 