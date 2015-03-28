<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 08.01.15 - 01:02
 */

namespace Prooph\Link\Application\Command;

use Prooph\Link\Application\SharedKernel\ConfigLocation;

/**
 * Class ChangeConnectorConfig
 *
 * @package SystemConfig\Command
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class ChangeConnectorConfig extends SystemCommand
{
    public static function ofConnector($connectorId, array $connectorConfig, ConfigLocation $configLocation)
    {
        return new self(__CLASS__, [
            'connector_id'     => $connectorId,
            'connector_config' => $connectorConfig,
            'config_location'  => $configLocation->toString()
        ]);
    }

    /**
     * @return string
     */
    public function connectorId()
    {
        return $this->payload['connector_id'];
    }

    /**
     * @return array
     */
    public function connectorConfig()
    {
        return $this->payload['connector_config'];
    }

    protected function assertPayload($aPayload = null)
    {
        if (! array_key_exists("connector_id",$aPayload)) throw new \InvalidArgumentException("Connector id missing");
        if (! array_key_exists("connector_config",$aPayload)) throw new \InvalidArgumentException("Connector config missing");
        if (! is_array($aPayload['connector_config'])) throw new \InvalidArgumentException("Connector config must be an array");
    }
}
 