<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 07.12.14 - 21:33
 */

namespace Prooph\Link\Application\Model\ProcessingConfig;

use Prooph\Link\Application\Command\CreateDefaultProcessingConfigFile;
use Prooph\Link\Application\Model\ProcessingConfig;

/**
 * Class CreateDefaultConfigFileHandler
 *
 * @package SystemConfig\Model\ProcessingConfig
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class CreateDefaultConfigFileHandler extends SystemConfigChangesHandler
{
    /**
     * @param CreateDefaultProcessingConfigFile $command
     * @throws \RuntimeException
     */
    public function handle(CreateDefaultProcessingConfigFile $command)
    {
        $processingConfig = ProcessingConfig::initializeWithDefaultsIn($command->configLocation(), $this->configWriter);

        $this->publishChangesOf($processingConfig);
    }
}
 