<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/16/15 - 7:15 PM
 */

namespace Prooph\Link\Application\Service;

/**
 * Interface TransactionEvent
 *
 * @package Prooph\Link\Application\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface TransactionEvent 
{
    /**
     * @param TransactionId $transactionId
     * @return void
     */
    public function setTransactionId(TransactionId $transactionId);

    /**
     * @return TransactionId
     */
    public function transactionId();
} 