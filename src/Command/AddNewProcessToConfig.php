<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 12/14/14 - 9:55 PM
 */
namespace Prooph\Link\Application\Command;

use Prooph\Link\Application\SharedKernel\ConfigLocation;

/**
 * Class AddNewProcessToConfig
 *
 * @package SystemConfig\Command
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class AddNewProcessToConfig extends SystemCommand
{
    /**
     * @param string $name
     * @param string $processType
     * @param string $startMessage
     * @param array $tasks
     * @param ConfigLocation $configLocation
     * @return AddNewProcessToConfig
     */
    public static function fromDefinition($name, $processType, $startMessage, array $tasks, ConfigLocation $configLocation)
    {
        return new self(
            __CLASS__,
            [
                "name" => $name,
                "process_type" => $processType,
                "start_message" => $startMessage,
                "tasks" => $tasks,
                "config_location" => $configLocation->toString()
            ]
        );
    }

    /**
     * @return string
     */
    public function processName()
    {
        return $this->payload['name'];
    }

    /**
     * @return string
     */
    public function processType()
    {
        return $this->payload['process_type'];
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
    public function tasks()
    {
        return $this->payload['tasks'];
    }

    protected function assertPayload($aPayload = null)
    {
        if (! array_key_exists("name",$aPayload)) throw new \InvalidArgumentException("Process name missing");
        if (! array_key_exists("process_type",$aPayload)) throw new \InvalidArgumentException("Process type missing");
        if (! array_key_exists("start_message",$aPayload)) throw new \InvalidArgumentException("Start message missing");
        if (! array_key_exists("tasks",$aPayload)) throw new \InvalidArgumentException("Tasks missing");
    }
}