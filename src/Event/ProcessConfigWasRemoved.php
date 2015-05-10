<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/19/15 - 4:57 PM
 */
namespace Prooph\Link\Application\Event;

/**
 * SystemChanged Event ProcessConfigWasRemoved
 *
 * @package Prooph\Link\Application\Event
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class ProcessConfigWasRemoved extends SystemChanged
{
    /**
     * @param array $oldProcessConfig
     * @param string $startMessage
     * @return ProcessConfigWasRemoved
     */
    public static function record(array $oldProcessConfig, $startMessage)
    {
        return self::occur(['start_message' => $startMessage, 'old_config' => $oldProcessConfig]);
    }

    /**
     * @return string
     */
    public function startMessage()
    {
        return $this->payload['start_message'];
    }

    /**
     * @return array
     */
    public function oldProcessConfig()
    {
        return $this->payload['old_config'];
    }
} 