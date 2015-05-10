<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/19/15 - 4:53 PM
 */
namespace Prooph\Link\Application\Model\ProcessingConfig;
use Prooph\Link\Application\Command\RemoveProcessConfig;
use Prooph\Link\Application\Model\ProcessingConfig;

/**
 * CommandHandler RemoveProcessConfigHandler
 *
 * @package Prooph\Link\Application\Model\ProcessingConfig
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class RemoveProcessConfigHandler extends SystemConfigChangesHandler
{
    public function handle(RemoveProcessConfig $command)
    {
        $processingConfig = ProcessingConfig::initializeFromConfigLocation($command->configLocation());


    }
} 