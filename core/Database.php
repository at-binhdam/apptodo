<?php

/**
 * This file is part of the binhdq/apptodo core
 * Create connection to DB and build method handle CRUD to data
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace Core;

class Database
{
    protected $pdo;

    protected $driver;

    protected $table;

    protected $fillable;

    const DRIVER_SQLITE = 'sqlite';

    const PREFIX_FIELD = ':';

    protected $fieldPrimaryKey = 'id';
    
    /**
     * Function constructor
     */
    public function __construct()
    {
        $this->driver = config('database.driver_default');
        $this->initConnection();
    }
    
    /**
     * Create connection to database
     *
     * @return void
     */
    protected function initConnection()
    {
        if ($this->driver == self::DRIVER_SQLITE) {
            $this->pdo = (new SQLiteConnection())->connect();
        }
        
        if ($this->pdo == null) {
            throw new \Exception("Whoops, could not connect to the {$this->driver} database!");
        }
    }

    /**
     * Exec command to query data
     *
     * @param string $command Query sql
     *
     * @return void
     */
    protected function execCommand(string $command)
    {
        return $this->pdo->exec($command);
    }

    /**
     * Exec the query to insert data
     *
     * @param array $params Data to insert
     *
     * @return boolean|int
     */
    protected function insert(array $params)
    {
        $fields = implode(", ", $this->fillable);
        $fieldsToBind = self::PREFIX_FIELD . implode(", " . self::PREFIX_FIELD, array_keys($params));

        $sql = " INSERT INTO {$this->table} ({$fields}) VALUES ({$fieldsToBind}) ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $this->pdo->lastInsertId();
    }

    /**
     * Exec the query to update data
     *
     * @param int   $id     Id
     * @param array $params Data to update
     *
     * @return boolean
     */
    protected function updateById(int $id, array $params)
    {
        $fields = array_keys($params);
        $fieldsToBind = "";

        $params[$this->fieldPrimaryKey] = $id;

        foreach ($fields as $field) {
            $fieldsToBind .= $field . '=' . self::PREFIX_FIELD . $field . ', ';
        }
        $fieldsToBind = trim($fieldsToBind, ", ");

        $sql = " UPDATE {$this->table} SET {$fieldsToBind} WHERE {$this->fieldPrimaryKey} = " . self::PREFIX_FIELD . $this->fieldPrimaryKey;
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($params);
    }

    /**
     * Exec the query to delete data by id
     *
     * @param int $id Id
     *
     * @return boolean
     */
    protected function deleteById(int $id)
    {
        $sql = " DELETE FROM {$this->table} WHERE {$this->fieldPrimaryKey} = " . self::PREFIX_FIELD . $this->fieldPrimaryKey;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(self::PREFIX_FIELD . $this->fieldPrimaryKey, $id);
 
        return $stmt->execute();
    }

    /**
     * Exec the query to delete all data
     *
     * @return boolean
     */
    protected function deleteAll()
    {
        $sql = " DELETE FROM {$this->table} ";
        
        $stmt = $this->pdo->prepare($sql);
 
        return $stmt->execute();
    }

    /**
     * Exec the query to get 1 record data by id
     *
     * @param int   $id     Id
     * @param array $fields The field to select
     *
     * @return array
     */
    protected function findById($id, $fields = ['*'])
    {
        $fields = implode(', ', $fields);
        $fields = trim($fields, ', ');

        $sql = " SELECT {$fields} FROM {$this->table} WHERE {$this->fieldPrimaryKey} = " . self::PREFIX_FIELD . $this->fieldPrimaryKey;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(self::PREFIX_FIELD . $this->fieldPrimaryKey, $id);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Exec the query to get all data
     *
     * @param array $fields The field to select
     *
     * @return array
     */
    protected function findAll($fields = ['*'])
    {
        $fields = implode(', ', $fields);
        $fields = trim($fields, ', ');

        $sql = " SELECT {$fields} FROM {$this->table} ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
