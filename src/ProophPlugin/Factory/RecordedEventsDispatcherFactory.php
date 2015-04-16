<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/4/15 - 3:52 PM
 */
namespace Prooph\Link\Application\ProophPlugin\Factory;

use Prooph\Link\Application\ProophPlugin\RecordedEventsDispatcher;
use Prooph\Link\Application\ProophPlugin\TransactionAwareAggregateChangedEventHydrator;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RecordedEventsDispatcherFactory
 *
 * @package Prooph\Link\Application\ProophPlugin\Factory
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class RecordedEventsDispatcherFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $services = $serviceLocator->getServiceLocator();

        return new RecordedEventsDispatcher(
            $services->get('prooph.psb.event_bus'),
            new TransactionAwareAggregateChangedEventHydrator()
        );
    }
}