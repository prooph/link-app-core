<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/4/15 - 5:56 PM
 */

namespace Prooph\Link\Application\Service;

use Doctrine\DBAL\Connection;

/**
 * Interface ApplicationDbAware
 *
 * @package Prooph\Link\Application\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface ApplicationDbAware
{
    /**
     * @param Connection $connection
     * @return mixed
     */
    public function setApplicationDb(Connection $connection);
} 