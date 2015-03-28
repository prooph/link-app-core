<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 3/20/15 - 10:36 PM
 */
namespace Prooph\Link\Application\Event;

/**
 * Class JavascriptTickerWasConfigured
 *
 * @package Prooph\Link\Application\Event
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
final class JavascriptTickerWasConfigured extends SystemChanged
{
    /**
     * Records config change for the javascript ticker
     *
     * @param array $newConfig
     * @param array $oldConfig
     * @return JavascriptTickerWasConfigured
     */
    public static function to(array $newConfig, array $oldConfig)
    {
        return self::occur(['old_config' => $oldConfig, 'new_config' => $newConfig]);
    }

    /**
     * @return array
     */
    public function oldConfiguration()
    {
        return $this->payload['old_config'];
    }

    /**
     * @return array
     */
    public function newConfiguration()
    {
        return $this->payload['new_config'];
    }
} 