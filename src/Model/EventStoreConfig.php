<?php
/*
* This file is part of prooph/link.
 * (c) prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 01.01.15 - 23:16
 */

namespace Prooph\Link\Application\Model;

use Prooph\Link\Application\Event\RecordsSystemChangedEvents;
use Prooph\Link\Application\Event\SystemChangedEventRecorder;
use Prooph\Link\Application\SharedKernel\ConfigLocation;
use Prooph\Link\Application\SharedKernel\SqliteDbFile;
use Prooph\Link\Application\Event\EventStoreSetUpWasUndone;
use Prooph\Link\Application\Event\EventStoreWasInitialized;
use Zend\Stdlib\ErrorHandler;

/**
 * Class EventStoreConfig
 *
 * Manages event store configuration
 *
 * @package SystemConfig\Model
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
final class EventStoreConfig implements SystemChangedEventRecorder
{
    use RecordsSystemChangedEvents;

    /**
     * @var array
     */
    private $config = array();

    /**
     * @var ConfigLocation
     */
    private $configLocation;

    /**
     * Local config file name
     *
     * @var string
     */
    private static $configFileName = 'prooph.eventstore.local.php';

    /**
     * @param SqliteDbFile $sqliteDbFile
     * @param ConfigLocation $configLocation
     * @param ConfigWriter $configWriter
     * @return EventStoreConfig
     */
    public static function initializeWithSqliteDb(SqliteDbFile $sqliteDbFile, ConfigLocation $configLocation, ConfigWriter $configWriter)
    {
        $config = [
            'proophessor' => [
                'event_store' => [
                    'adapter' => [
                        'type' => 'Prooph\EventStore\Adapter\Doctrine\DoctrineEventStoreAdapter',
                        'options' => [
                            'connection' => [
                                'driver' => 'pdo_sqlite',
                                'path'   => $sqliteDbFile->toString()
                            ],
                            'serializer_adapter' => 'json',
                        ]
                    ]
                ]
            ]
        ];

        $instance = new self($config, $configLocation);

        $configWriter->writeNewConfigToDirectory($config, $configLocation->toString() . DIRECTORY_SEPARATOR . $instance->configFileName());

        $instance->recordThat(EventStoreWasInitialized::withSqliteDb($sqliteDbFile, $configLocation, $instance->configFileName()));

        return $instance;
    }

    /**
     * @param string $configLocation
     * @param string $sqliteDbFile
     * @return EventStoreSetUpWasUndone
     */
    public static function undoEventStoreSetUp($configLocation, $sqliteDbFile)
    {
        ErrorHandler::start();

        if (file_exists($configLocation . DIRECTORY_SEPARATOR . self::$configFileName))
            unlink($configLocation . DIRECTORY_SEPARATOR . self::$configFileName);

        if (file_exists($sqliteDbFile))
            unlink($sqliteDbFile);

        ErrorHandler::stop();

        return EventStoreSetUpWasUndone::in($configLocation . DIRECTORY_SEPARATOR . self::$configFileName);
    }

    /**
     * @param array $config
     * @param ConfigLocation $configLocation
     */
    private function __construct(array $config, ConfigLocation $configLocation)
    {
        $this->configLocation = $configLocation;
        $this->setConfig($config);
    }

    /**
     * @return string
     */
    public function configFileName()
    {
        return self::$configFileName;
    }

    /**
     * Returns array representation of the event store configuration
     *
     * @return array
     */
    public function toArray()
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @throws \InvalidArgumentException
     */
    private function setConfig(array $config)
    {
        if (! array_key_exists('proophessor', $config)) throw new \InvalidArgumentException('Missing the root key proophessor in configuration');
        if (! is_array($config['proophessor'])) throw new \InvalidArgumentException('proophessor config must be an array');
        if (! array_key_exists('event_store', $config['proophessor'])) throw new \InvalidArgumentException('Missing the event_store key in proophessor configuration');
        if (! is_array($config['proophessor']['event_store'])) throw new \InvalidArgumentException('proophessor.event_store config must be an array');
        if (! array_key_exists('adapter', $config['proophessor']['event_store'])) throw new \InvalidArgumentException('Missing key adapter in proophessor.event_store configuration');
        if (! is_array($config['proophessor']['event_store']['adapter'])) throw new \InvalidArgumentException('proophessor.event_store adapter config must be an array');
        if (! array_key_exists('type', $config['proophessor']['event_store']['adapter'])) throw new \InvalidArgumentException('Missing key type in proophessor.event_store adapter configuration');

        $this->config = $config;
    }
}
 