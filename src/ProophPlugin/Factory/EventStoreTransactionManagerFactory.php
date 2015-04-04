<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/4/15 - 12:46 AM
 */
namespace Prooph\Link\Application\ProophPlugin\Factory;

use Prooph\Link\Application\ProophPlugin\EventStoreTransactionManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EventStoreTransactionManagerFactory
 *
 * @package Prooph\Link\Application\ProophPlugin\Factory
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class EventStoreTransactionManagerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new EventStoreTransactionManager($serviceLocator->get('prooph.event_store'));
    }
}