<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 07.01.15 - 21:56
 */

namespace Prooph\Link\Application\Model\ProcessingConfig;

use Prooph\ServiceBus\EventBus;
use Prooph\Link\Application\Model\ConfigWriter;
use Prooph\Link\Application\Model\ProcessingConfig;
use Prooph\Link\Application\Service\HandlesSystemConfigChanges;

/**
 * Class SystemConfigChangesHandler
 *
 * @package SystemConfig\Model\ProcessingConfig
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class SystemConfigChangesHandler implements HandlesSystemConfigChanges
{
    /**
     * @var EventBus
     */
    protected $eventBus;

    /**
     * @var ConfigWriter
     */
    protected $configWriter;

    public function publishChangesOf(ProcessingConfig $processingConfig)
    {
        foreach ($processingConfig->popRecordedEvents() as $recordedEvent) $this->eventBus->dispatch($recordedEvent);
    }

    /**
     * @param ConfigWriter $configWriter
     * @return void
     */
    public function setConfigWriter(ConfigWriter $configWriter)
    {
        $this->configWriter = $configWriter;
    }

    /**
     * @param EventBus $eventBus
     * @return void
     */
    public function setEventBus(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }
}
 