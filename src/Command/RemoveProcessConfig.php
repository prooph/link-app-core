<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/19/15 - 4:50 PM
 */
namespace Prooph\Link\Application\Command;

use Prooph\Link\Application\SharedKernel\ConfigLocation;

/**
 * SystemCommand RemoveProcessConfig
 *
 * @package Prooph\Link\Application\Command
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class RemoveProcessConfig extends SystemCommand
{
    /**
     * @param string $messageName
     * @param ConfigLocation $configLocation
     * @return RemoveProcessConfig
     */
    public static function ofProcessTriggeredByMessage($messageName, ConfigLocation $configLocation)
    {
        return new self(
            __CLASS__,
            [
                'start_message' => $messageName,
                'config_location' => $configLocation->toString()
            ]
        );
    }

    /**
     * @return string
     */
    public function startMessage()
    {
        return $this->payload['start_message'];
    }

    protected function assertPayload($aPayload = null)
    {
        if (! is_array($aPayload)) throw new \InvalidArgumentException("Payload must be an array");
        if (! array_key_exists("start_message",$aPayload)) throw new \InvalidArgumentException("Name of start message missing");
        if (! is_array($aPayload['process_config'])) throw new \InvalidArgumentException("Process config must be an array");
    }
}