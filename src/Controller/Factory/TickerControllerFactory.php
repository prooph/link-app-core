<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/27/15 - 10:15 PM
 */
namespace Prooph\Link\Application\Controller\Factory;

use Prooph\Link\Application\Controller\TickerController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class TickerControllerFactory
 *
 * @package Prooph\Link\Application\Controller\Factory
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class TickerControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new TickerController($serviceLocator->getServiceLocator()->get('proophessor.event_bus'));
    }
}