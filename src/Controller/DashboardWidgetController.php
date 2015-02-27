<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.14 - 22:32
 */

namespace Prooph\Link\Application\Controller;

use Prooph\Link\Application\Model\ProcessingConfig;
use Prooph\Link\Dashboard\Controller\AbstractWidgetController;
use Prooph\Link\Dashboard\View\DashboardWidget;

/**
 * Class DashboardWidgetController
 *
 * @package SystemConfig\src\Controller
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class DashboardWidgetController extends AbstractWidgetController
{
    /**
     * @return DashboardWidget
     */
    public function widgetAction()
    {
        $params = [];

        $params['processingConfig'] = $this->systemConfig;

        $params['config_dir_is_writable'] = is_writable($this->systemConfig->getConfigLocation()->toString());

        if ($this->systemConfig->isConfigured()) {
            $params['config_is_writable'] = is_writable($this->systemConfig->getConfigLocation()->toString() . DIRECTORY_SEPARATOR . ProcessingConfig::configFileName());
        } else {
            $params['config_is_writable'] = true;
        }

        $params['config_dir'] = $this->systemConfig->getConfigLocation()->toString();
        $params['config_file_name'] = ProcessingConfig::configFileName();

        return DashboardWidget::initialize('prooph/link/system-config/dashboard/widget', 'System Configuration', 4, $params);
    }
}
 