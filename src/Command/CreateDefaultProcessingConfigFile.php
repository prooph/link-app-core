<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 07.12.14 - 21:31
 */

namespace Prooph\Link\Application\Command;

use Prooph\Link\Application\SharedKernel\ConfigLocation;

/**
 * Command CreateDefaultProcessingConfigFile
 *
 * @package SystemConfig\Command
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class CreateDefaultProcessingConfigFile extends SystemCommand
{
    /**
     * @var ConfigLocation
     */
    private $configLocation;

    /**
     * @param ConfigLocation $configLocation
     * @return CreateDefaultProcessingConfigFile
     * @throws \InvalidArgumentException
     */
    public static function in(ConfigLocation $configLocation)
    {
        $instance = new self(__CLASS__, ['config_location' => $configLocation->toString()]);

        $instance->configLocation = $configLocation;

        return $instance;
    }

    /**
     * @param null|array $aPayload
     * @throws \InvalidArgumentException
     */
    protected function assertPayload($aPayload = null)
    {
        //Nothing to do here
    }
}
 