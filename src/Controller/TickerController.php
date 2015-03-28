<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/22/15 - 11:08 PM
 */
namespace Prooph\Link\Application\Controller;

use Prooph\Link\Application\Event\TickOccurred;
use Prooph\ServiceBus\EventBus;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Class TickerController
 *
 * @package Prooph\Link\Application\Controller
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class TickerController extends AbstractActionController
{
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @param EventBus $eventBus
     */
    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    /**
     * Dispatch a tick event
     *
     * @return array
     */
    public function tickAction()
    {
        $this->eventBus->dispatch(new TickOccurred());
        return new JsonModel(['success' => true]);
    }
} 