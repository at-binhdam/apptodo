<?php

/**
 * This file is part of the application
 * Model Task
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace App\Models;

class TaskModel extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'name', 'start_date', 'end_date', 'status'
    ];

    /**
     * Function constructor
     */
    public function __construct()
    {
        $this->migrateTable = config('database.migration.tables.tasks');
        parent::__construct();
    }
    
    /**
     * Function insert a task into database
     *
     * @param array $infoTask Info task
     *
     * @return boolean
     */
    public function insertTask(array $infoTask)
    {
        return $this->insert($infoTask);
    }

    /**
     * Function update a task by ID
     *
     * @param int   $id       Info task
     * @param array $infoTask Info task
     *
     * @return boolean
     */
    public function updateTaskById(int $id, array $infoTask)
    {
        return $this->updateById($id, $infoTask);
    }

    /**
     * Function delete a task by ID
     *
     * @param int $id Id of task
     *
     * @return boolean
     */
    public function deleteTaskById(int $id)
    {
        return $this->deleteById($id);
    }

    /**
     * Function delete all task
     *
     * @return boolean
     */
    public function deleteAllTask()
    {
        return $this->deleteAll();
    }

    /**
     * Function find a task by ID
     *
     * @param int   $id     Info task
     * @param array $fields Fields to select
     *
     * @return array
     */
    public function findTaskById(int $id, array $fields = ['*'])
    {
        return $this->findById($id, $fields);
    }

    /**
     * Function find all task
     *
     * @param array $fields Fields to select
     *
     * @return array
     */
    public function findAllTask(array $fields = ['*'])
    {
        return $this->findAll($fields);
    }
}
