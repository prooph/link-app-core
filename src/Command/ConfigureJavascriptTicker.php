<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/20/15 - 10:49 PM
 */
namespace Prooph\Link\Application\Command;

use Prooph\Link\Application\SharedKernel\ConfigLocation;

/**
 * ConfigureJavascriptTicker Command
 *
 * @package Prooph\Link\Application\Command
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class ConfigureJavascriptTicker extends SystemCommand
{
    /**
     * @param bool $enabled
     * @param int $interval
     * @param ConfigLocation $configLocation
     * @return ConfigureJavascriptTicker
     */
    public static function set($enabled, $interval, ConfigLocation $configLocation)
    {
        return new self(__CLASS__, [
            'enabled' => $enabled,
            'interval' => $interval,
            'config_location' => $configLocation->toString(),
        ]);
    }

    /**
     * @return bool
     */
    public function enabled()
    {
        return $this->payload['enabled'];
    }

    /**
     * @return int
     */
    public function interval()
    {
        return $this->payload['interval'];
    }

    /**
     * Assert that payload contains all required information for this command
     *
     * @param null|array $aPayload
     * @throws \InvalidArgumentException
     */
    protected function assertPayload($aPayload = null)
    {
        if (! array_key_exists('enabled', $aPayload) || ! array_key_exists('interval', $aPayload)) {
            throw new \InvalidArgumentException('Payload does not contain a enabled or interval key');
        }

        if (! is_bool($aPayload['enabled'])) throw new \InvalidArgumentException('Enabled flag must be a boolean value');
        if (! is_int($aPayload['interval'])) throw new \InvalidArgumentException('Ticker interval must be an integer');
    }
}