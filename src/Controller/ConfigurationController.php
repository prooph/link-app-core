<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 12/8/14 - 5:31 PM
 */
namespace Prooph\Link\Application\Controller;

use Prooph\Link\Application\Command\ConfigureJavascriptTicker;
use Prooph\Link\Application\Service\AbstractActionController;
use Prooph\Link\Application\SharedKernel\ConfigLocation;
use Prooph\Processing\Processor\NodeName;
use Prooph\Link\Application\Command\ChangeNodeName;
use Prooph\Link\Application\Definition;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

/**
 * Class ConfigurationController
 *
 * This controller respond only to AJAX requests. The UI triggers config changes individually.
 *
 * @package Prooph\Link\Application\Controller
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class ConfigurationController extends AbstractActionController
{
    /**
     * Handles a POST request that want to change the node name
     */
    public function changeNodeNameAction()
    {
        $nodeName = $this->bodyParam('node_name');

        if (! is_string($nodeName) || strlen($nodeName) < 3) {
            return new ApiProblemResponse(new ApiProblem(422, $this->translator->translate('The node name must be at least 3 characters long')));
        }

        $this->commandBus->dispatch(ChangeNodeName::to(
            NodeName::fromString($nodeName),
            ConfigLocation::fromPath(Definition::getSystemConfigDir())
        ));

        return ['success' => true];
    }

    /**
     * Handles a POST request to configure the javascript ticker
     */
    public function configureJavascriptTickerAction()
    {
        $tickerEnabled = $this->bodyParam('enabled');
        $tickerInterval = $this->bodyParam('interval');

        if (! is_bool($tickerEnabled)) {
            return new ApiProblemResponse(new ApiProblem(422, $this->translator->translate('The enabled flag should be a boolean value')));
        }

        if (! is_int($tickerInterval) || $tickerInterval <= 0) {
            return new ApiProblemResponse(new ApiProblem(422, $this->translator->translate('The ticker interval should greater than zero')));
        }

        $this->commandBus->dispatch(
            ConfigureJavascriptTicker::set(
                $tickerEnabled,
                $tickerInterval,
                ConfigLocation::fromPath(Definition::getSystemConfigDir())
            )
        );

        return ['success' => true];
    }
} 