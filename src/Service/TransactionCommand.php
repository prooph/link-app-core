<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/4/15 - 12:40 AM
 */

namespace Prooph\Link\Application\Service;

/**
 * Interface TransactionCommand
 *
 * This is a marker interface telling the Prooph\Link\Application\ProophPlugin\EventStoreTransactionManager
 * that this command should be wrapped in a transaction.
 *
 * @package Prooph\Link\Application\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface TransactionCommand 
{
} 