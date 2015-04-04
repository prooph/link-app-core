<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/4/15 - 7:45 PM
 */
namespace Prooph\Link\Application\Service;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ApplicationDbProvider
 *
 * @package Prooph\Link\Application\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class ApplicationDbProvider implements InitializerInterface
{
    /**
     * Initialize
     *
     * @param $instance
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if ($instance instanceof ApplicationDbAware) {
            $instance->setApplicationDb($serviceLocator->get('prooph.link.app.db'));
        }
    }
}