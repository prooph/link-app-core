<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/28/15 - 11:22 PM
 */
namespace Prooph\Link\Application\Model\ProcessingConfig;

use Prooph\Link\Application\Command\DisableWorkflowProcessorMessageQueue;
use Prooph\Link\Application\Model\ProcessingConfig;

/**
 * Class DisableWorkflowProcessorMessageQueueHandler
 *
 * Handles DisableWorkflowProcessorMessageQueue command
 *
 * @package Prooph\Link\Application\Model\ProcessingConfig
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class DisableWorkflowProcessorMessageQueueHandler extends SystemConfigChangesHandler
{
    /**
     * @param DisableWorkflowProcessorMessageQueue $command
     */
    public function handle(DisableWorkflowProcessorMessageQueue $command)
    {
        $processingConfig = ProcessingConfig::initializeFromConfigLocation($command->configLocation());

        $processingConfig->disableWorkflowProcessorMessageQueue($this->configWriter);

        $this->publishChangesOf($processingConfig);
    }
} 