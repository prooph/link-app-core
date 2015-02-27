<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 06.12.14 - 21:26
 */
namespace Prooph\Link\Application;

use Prooph\Link\Application\Service\ActionControllerInitializer;
use Prooph\Link\Application\Service\ControllerTranslatorProvider;
use Prooph\Link\Application\Service\SystemConfigChangesHandlerProvider;
use Prooph\Link\Application\Service\SystemConfigProvider;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        /** @var $sm ControllerManager */
        $sm = $e->getApplication()->getServiceManager();
        $cm = $sm->get('ControllerLoader');
        $cm->addInitializer(new ActionControllerInitializer());
        $cm->addInitializer(new ControllerTranslatorProvider());
        $configProvider = new SystemConfigProvider();
        $sm->addInitializer($configProvider);
        $cm->addInitializer($configProvider);

        $systemChangesHandlerProvider = new SystemConfigChangesHandlerProvider();
        $sm->addInitializer($systemChangesHandlerProvider);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
