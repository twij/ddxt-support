<?php

namespace Ddxt\Support\TransactionManager;

use Illuminate\Database\DatabaseManager;

trait TransactionManager
{
    /**
     * Database manager
     *
     * @var DatabaseManager
     */
    protected DatabaseManager $database_manager;

    /**
     * Initialise database manager
     *
     * @return void
     */
    public function initTransactions()
    {
        $this->database_manager = app()
            ->make('Illuminate\Database\DatabaseManager');
    }

    /**
     * Check if database manager is ready
     *
     * @return boolean  True or throw
     */
    public function isTransactionInitialised(): bool
    {
        if (isset($this->database_manager)) {
            return true;
        } else {
            throw new \Exception('Database manager not initialised. Use initTransactions()');
        }
    }

    /**
     * Start new transaction
     *
     * @return void
     */
    public function beginTransaction()
    {
        if ($this->isTransactionInitialised()) {
            $this->database_manager->beginTransaction();
        }
    }

    /**
     * Rollback transaction
     *
     * @return void
     */
    public function rollbackTransaction()
    {
        if ($this->isTransactionInitialised()) {
            $this->database_manager->rollback();
        }
    }

    /**
     * Commit transaction
     *
     * @return void
     */
    public function commitTransaction()
    {
        if ($this->isTransactionInitialised()) {
            $this->database_manager->commit();
        }
    }

    /**
     * Wrap transaction
     *
     * @param  callable  $function  Transaction closure
     *
     * @return void
     */
    public function transaction(callable $function)
    {
        if ($this->isTransactionInitialised()) {
            $this->database_manager->transaction($function);
        }
    }
}
