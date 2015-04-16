<?php
/*
 * This file is part of prooph/link.
 * (c) 2014-2015 prooph software GmbH <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 4/16/15 - 7:11 PM
 */

namespace Prooph\Link\Application\Service;

/**
 * Trait TransactionIdGenerator
 *
 * Trait to add TransactionId generation capability to a TransactionCommand
 *
 * @package Prooph\Link\Application\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
trait TransactionIdGenerator
{
    /**
     * @var TransactionId
     */
    private $transactionId;

    /**
     * @return TransactionId
     */
    public function transactionId()
    {
        if (is_null($this->transactionId)) {
            $this->transactionId = TransactionId::generate();
        }

        return $this->transactionId;
    }
} 