<?php

/**
 * This file is part of the application
 * Model Base
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace App\Models;

use Core\Database;

class Model extends Database
{
    protected $table;
    
    protected $migrateTable;

    protected $fillable;

    /**
     * Function construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->createTable();
    }
    
    /**
     * Function create table
     *
     * @return void
     */
    public function createTable()
    {
        $this->execCommand($this->migrateTable);
    }
}
