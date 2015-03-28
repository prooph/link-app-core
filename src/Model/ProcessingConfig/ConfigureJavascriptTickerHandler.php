<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/20/15 - 11:02 PM
 */
namespace Prooph\Link\Application\Model\ProcessingConfig;

use Prooph\Link\Application\Command\ConfigureJavascriptTicker;
use Prooph\Link\Application\Model\ProcessingConfig;

/**
 * Class ConfigureJavascriptTickerHandler
 *
 * @package Prooph\Link\Application\Model\ProcessingConfig
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class ConfigureJavascriptTickerHandler extends SystemConfigChangesHandler
{
    /**
     * @param ConfigureJavascriptTicker $command
     */
    public function handle(ConfigureJavascriptTicker $command)
    {
        $processingConfig = ProcessingConfig::initializeFromConfigLocation($command->configLocation());

        $processingConfig->configureJavascriptTicker([
            'enabled' => $command->enabled(),
            'interval' => $command->interval()
        ], $this->configWriter);

        $this->publishChangesOf($processingConfig);
    }
} 