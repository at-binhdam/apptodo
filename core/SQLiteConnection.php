<?php

/**
 * This file is part of the binhdq/apptodo core
 * Create connection to database of sqlite
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace Core;

class SQLiteConnection
{
    protected $pdo;

    /**
     * Create connection to database
     *
     * @return object
     */
    public function connect()
    {
        if ($this->pdo == null) {
            $this->pdo = new \PDO("sqlite:" . config('database.connections.sqlite.path'));
        }
        
        return $this->pdo;
    }
}
