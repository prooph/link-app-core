<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/16/15 - 7:16 PM
 */
namespace Prooph\Link\Application\Service;

/**
 * Trait TransactionIdAware
 *
 * Trait to simplify consuming and providing the TransactionId of the transaction that had produced the TransactionEvent
 *
 * @package Prooph\Link\Application\Service
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 */
trait TransactionIdAware
{
    /**
     * @var TransactionId
     */
    private $transactionId;

    public function setTransactionId(TransactionId $transactionId) {
        $this->transactionId = $transactionId;
    }

    /**
     * @return TransactionId
     */
    public function transactionId()
    {
        return $this->transactionId;
    }
} 