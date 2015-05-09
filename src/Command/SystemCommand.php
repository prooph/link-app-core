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

use Prooph\Common\Messaging\Command;
use Prooph\Link\Application\SharedKernel\ConfigLocation;
use Prooph\Proophessor\EventStore\AutoCommitCommand;
use Rhumsaa\Uuid\Uuid;

/**
 * Command SystemCommand
 *
 * All commands that trigger changes in the system must be of type SystemCommand
 *
 * @package Application\Command
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
abstract class SystemCommand extends Command implements AutoCommitCommand
{
    /**
     * @param string $messageName
     * @param null $payload
     * @param int $version
     * @param Uuid $uuid
     * @param \DateTimeImmutable $createdAt
     * @param array $metadata
     * @throws \RuntimeException
     */
    protected function __construct($messageName, $payload = null, $version = 1, Uuid $uuid = null, \DateTimeImmutable $createdAt = null, array $metadata = [])
    {
        $this->assertCommonPayload($payload);
        $this->assertPayload($payload);
        parent::__construct($messageName, $payload, $version, $uuid, $createdAt, $metadata);
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