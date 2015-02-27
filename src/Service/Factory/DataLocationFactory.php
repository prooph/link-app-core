<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 1/26/15 - 8:07 PM
 */
namespace Prooph\Link\Application\Service\Factory;

use Prooph\Link\Application\SharedKernel\DataLocation;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DataLocationFactory
 *
 * @package Application\Service\Factory
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class DataLocationFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @throws \RuntimeException
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');

        if (!is_array($config)) {
            throw new \RuntimeException("Expected application config to be an array. Got " . gettype($config));
        }

        if (! isset($config['system_data_dir'])) {
            throw new \RuntimeException("Missing system_data_dir key in application configuration. Please add the key to your config and point it to the data directory of your application!");
        }

        return DataLocation::fromPath($serviceLocator->get('config')['system_data_dir']);
    }
}