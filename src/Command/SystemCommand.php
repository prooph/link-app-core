<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 12/8/14 - 7:28 PM
 */
namespace Prooph\Link\Application\Command;

use Prooph\Link\Application\SharedKernel\ConfigLocation;
use Prooph\ServiceBus\Command;
use Rhumsaa\Uuid\Uuid;

/**
 * Command SystemCommand
 *
 * All commands that trigger changes in the system must be of type SystemCommand
 *
 * @package Application\Command
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
abstract class SystemCommand extends Command
{
    /**
     * @throws \BadMethodCallException
     * @return Command
     */
    public static function getNew()
    {
        throw new \BadMethodCallException('Calling Command::getNew is not allowed!');
    }

    /**
     * @param mixed $aPayload
     * @throws \BadMethodCallException
     * @return Command
     */
    public static function fromPayload($aPayload)
    {
        throw new \BadMethodCallException('Calling Command::fromPayload is not allowed!');
    }

    /**
     * @param string $aMessageName
     * @param null $aPayload
     * @param int $aVersion
     * @param Uuid $aUuid
     * @param \DateTime $aCreatedOn
     * @throws \Prooph\ServiceBus\Exception\RuntimeException
     */
    public function __construct($aMessageName, $aPayload = null, $aVersion = 1, Uuid $aUuid = null, \DateTime $aCreatedOn = null)
    {
        $this->assertCommonPayload($aPayload);
        $this->assertPayload($aPayload);
        parent::__construct($aMessageName, $aPayload, $aVersion, $aUuid, $aCreatedOn);
    }

    abstract protected function assertPayload($aPayload = null);

    /**
     * @return ConfigLocation
     */
    public function configLocation()
    {
        return ConfigLocation::fromPath($this->payload['config_location']);
    }

    private function assertCommonPayload($aPayload)
    {
        if (! is_array($aPayload) || ! array_key_exists('config_location', $aPayload)) {
            throw new \InvalidArgumentException('Payload does not contain a config_location');
        }

        if (! is_string($aPayload['config_location'])) {
            throw new \InvalidArgumentException("Config location must be string, but type " . gettype($aPayload['config_location']) . " given");
        }
    }
} 