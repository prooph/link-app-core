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

return array(
    'prooph.link.dashboard' => [
        'system_config_widget' => [
            'controller' => 'Prooph\Link\Application\Controller\DashboardWidget',
            'order' => 101 //100 - 200 config order range
        ]
    ],
    'router' => [
        'routes' => [
            'prooph.link' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/prooph/link',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'system_config' => [
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route' => '/system-config',
                            'defaults' => array(
                                'controller' => 'Prooph\Link\Application\Controller\Overview',
                                'action'     => 'show',
                            ),
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'processing_set_up' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/processing-set-up',
                                    'defaults' => [
                                        'controller' => 'Prooph\Link\Application\Controller\ProcessingSetUp',
                                        'action' => 'run'
                                    ]
                                ],
                            ],
                            'change_node_name' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/change-node-name',
                                    'defaults' => [
                                        'controller' => 'Prooph\Link\Application\Controller\Configuration',
                                        'action' => 'change-node-name'
                                    ]
                                ]
                            ],
                            'configure_js_ticker' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/configure-js-ticker',
                                    'defaults' => [
                                        'controller' => 'Prooph\Link\Application\Controller\Configuration',
                                        'action' => 'configure-javascript-ticker'
                                    ]
                                ]
                            ],
                            'configure_workflow_processor_message_queue' => [
                                'type' => 'Literal',
                                'options' => [
                                    'route' => '/configure-workflow-processor-message-queue',
                                    'defaults' => [
                                        'controller' => 'Prooph\Link\Application\Controller\Configuration',
                                        'action' => 'configure-workflow-processor-message-queue'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'tick' => [
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route' => '/tick',
                            'defaults' => [
                                'controller' => 'Prooph\Link\Application\Controller\Ticker',
                                'action' => 'tick'
                            ]
                        ],
                    ]
                ]
            ],
        ]
    ],
    'service_manager' => [
        'invokables' => [
            //System config writer
            'prooph.link.system_config.config_writer' => \Prooph\Link\Application\Service\ConfigWriter\ZendPhpArrayWriter::class,
            //Command handlers
            \Prooph\Link\Application\Model\ProcessingConfig\CreateDefaultConfigFileHandler::class   => \Prooph\Link\Application\Model\ProcessingConfig\CreateDefaultConfigFileHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\InitializeEventStoreHandler::class      => \Prooph\Link\Application\Model\ProcessingConfig\InitializeEventStoreHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\ChangeNodeNameHandler::class            => \Prooph\Link\Application\Model\ProcessingConfig\ChangeNodeNameHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\AddNewProcessToConfigHandler::class     => \Prooph\Link\Application\Model\ProcessingConfig\AddNewProcessToConfigHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\ChangeProcessConfigHandler::class       => \Prooph\Link\Application\Model\ProcessingConfig\ChangeProcessConfigHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\UndoSystemSetUpHandler::class           => \Prooph\Link\Application\Model\ProcessingConfig\UndoSystemSetUpHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\AddConnectorToConfigHandler::class      => \Prooph\Link\Application\Model\ProcessingConfig\AddConnectorToConfigHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\ChangeConnectorConfigHandler::class     => \Prooph\Link\Application\Model\ProcessingConfig\ChangeConnectorConfigHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\ConfigureJavascriptTickerHandler::class => \Prooph\Link\Application\Model\ProcessingConfig\ConfigureJavascriptTickerHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\RemoveProcessConfigHandler::class      => \Prooph\Link\Application\Model\ProcessingConfig\RemoveProcessConfigHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\EnableWorkflowProcessorMessageQueueHandler::class  => \Prooph\Link\Application\Model\ProcessingConfig\EnableWorkflowProcessorMessageQueueHandler::class,
            \Prooph\Link\Application\Model\ProcessingConfig\DisableWorkflowProcessorMessageQueueHandler::class => \Prooph\Link\Application\Model\ProcessingConfig\DisableWorkflowProcessorMessageQueueHandler::class,
        ],
        'factories' => [
            'prooph.link.app.config_location'     => \Prooph\Link\Application\Service\Factory\ConfigLocationFactory::class,
            'prooph.link.app.data_location'       => \Prooph\Link\Application\Service\Factory\DataLocationFactory::class,
            'prooph.link.app.data_type_location'  => \Prooph\Link\Application\Service\Factory\ApplicationDataTypeLocationFactory::class,
            'prooph.link.app.location_translator' => \Prooph\Link\Application\SharedKernel\Factory\LocationTranslatorFactory::class,
            'prooph.link.app.db'                  => \Prooph\Link\Application\Service\Factory\ApplicationDbFactory::class,
            'prooph.link.app.riot_tag.collection.resolver' => \Prooph\Link\Application\Service\Factory\RiotTagCollectionResolverFactory::class,
            //Projections
            'prooph.link.system_config' => \Prooph\Link\Application\Service\SystemConfigFactory::class,
        ],
        'aliases' => [
            'processing_config' => 'prooph.link.system_config',
        ]
    ],
    'controllers' => array(
        'factories' => array(
            'Prooph\Link\Application\Controller\Ticker'            => \Prooph\Link\Application\Controller\Factory\TickerControllerFactory::class,
        ),
        'invokables' => array(
            'Prooph\Link\Application\Controller\ProcessingSetUp'   => \Prooph\Link\Application\Controller\ProcessingSetUpController::class,
            'Prooph\Link\Application\Controller\Overview'          => \Prooph\Link\Application\Controller\OverviewController::class,
            'Prooph\Link\Application\Controller\Configuration'     => \Prooph\Link\Application\Controller\ConfigurationController::class,
            'Prooph\Link\Application\Controller\DashboardWidget'   => \Prooph\Link\Application\Controller\DashboardWidgetController::class,
        ),
    ),
    'proophessor' => [
        'command_router_map' => [
            \Prooph\Link\Application\Command\CreateDefaultProcessingConfigFile::class    => \Prooph\Link\Application\Model\ProcessingConfig\CreateDefaultConfigFileHandler::class,
            \Prooph\Link\Application\Command\InitializeEventStore::class                 => \Prooph\Link\Application\Model\ProcessingConfig\InitializeEventStoreHandler::class,
            \Prooph\Link\Application\Command\ChangeNodeName::class                       => \Prooph\Link\Application\Model\ProcessingConfig\ChangeNodeNameHandler::class,
            \Prooph\Link\Application\Command\ConfigureJavascriptTicker::class            => \Prooph\Link\Application\Model\ProcessingConfig\ConfigureJavascriptTickerHandler::class,
            \Prooph\Link\Application\Command\AddNewProcessToConfig::class                => \Prooph\Link\Application\Model\ProcessingConfig\AddNewProcessToConfigHandler::class,
            \Prooph\Link\Application\Command\ChangeProcessConfig::class                  => \Prooph\Link\Application\Model\ProcessingConfig\ChangeProcessConfigHandler::class,
            \Prooph\Link\Application\Command\UndoSystemSetUp::class                      => \Prooph\Link\Application\Model\ProcessingConfig\UndoSystemSetUpHandler::class,
            \Prooph\Link\Application\Command\AddConnectorToConfig::class                 => \Prooph\Link\Application\Model\ProcessingConfig\AddConnectorToConfigHandler::class,
            \Prooph\Link\Application\Command\ChangeConnectorConfig::class                => \Prooph\Link\Application\Model\ProcessingConfig\ChangeConnectorConfigHandler::class,
            \Prooph\Link\Application\Command\RemoveProcessConfig::class                  => \Prooph\Link\Application\Model\ProcessingConfig\RemoveProcessConfigHandler::class,
            \Prooph\Link\Application\Command\EnableWorkflowProcessorMessageQueue::class  => \Prooph\Link\Application\Model\ProcessingConfig\EnableWorkflowProcessorMessageQueueHandler::class,
            \Prooph\Link\Application\Command\DisableWorkflowProcessorMessageQueue::class => \Prooph\Link\Application\Model\ProcessingConfig\DisableWorkflowProcessorMessageQueueHandler::class,
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'prooph/link/system-config/dashboard/widget' => __DIR__ . '/../view/system-config/dashboard/widget.phtml',
            'prooph/link/system-config/overview/show' => __DIR__ . '/../view/system-config/overview/show.phtml',
            'prooph/link/system-config/riot-tag/system-configurator' => __DIR__ . '/../view/system-config/riot-tag/system-configurator.phtml',
            'prooph/link/system-config/riot-tag/system-node-name' => __DIR__ . '/../view/system-config/riot-tag/system-node-name.phtml',
            'prooph/link/system-config/riot-tag/system-ticker' => __DIR__ . '/../view/system-config/riot-tag/system-ticker.phtml',
            'prooph/link/system-config/riot-tag/system-workflow-processor-message-queue' => __DIR__ . '/../view/system-config/riot-tag/system-workflow-processor-message-queue.phtml',
        ],
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ],
    'view_helpers' => [
        'invokables'=> [
            'riotTag' => 'Prooph\Link\Application\View\Helper\RiotTag'
        ],
        'factories' => [
            'javascriptTicker' => \Prooph\Link\Application\View\Helper\JavascriptTickerFactory::class,
        ]
    ],
    'asset_manager' => [
        'resolvers' => [
            'prooph.link.app.riot_tag.collection.resolver' => 2000
        ],
        'resolver_configs' => [
            //Riot tags are resolved by the Application\Service\RiotTagCollectionResolver
            'riot-tags' => [
                'js/prooph/link/system-config/app.js' => [
                    'prooph/link/system-config/riot-tag/system-configurator',
                    'prooph/link/system-config/riot-tag/system-node-name',
                    'prooph/link/system-config/riot-tag/system-ticker',
                    'prooph/link/system-config/riot-tag/system-workflow-processor-message-queue',
                ],
            ],
            'paths' => [
                __DIR__ . '/../public',
            ],
            'map' => [
                'js/prooph/link/app/processing.ticker.js' => __DIR__ . '/../public/js/processing.ticker.js',
            ],
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Prooph\Link\Application\Controller\Configuration' => 'Json',
        ],
        'accept_whitelist' => [
            'Prooph\Link\Application\Controller\Configuration' => ['application/json'],
        ],
        'content_type_whitelist' => [
            'Prooph\Link\Application\Controller\Configuration' => ['application/json'],
        ],
    ],
    'zf-api-problem' => [
        'accept_filters' => [
            'application/json',
            'application/*+json',
        ]
    ],
);
