<?php

/**
 * This file is part of the application
 * Task Controller
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace App\Controllers;

use App\Models\TaskModel;

class TaskController
{
    public $taskModel;

    /**
     * Function constructor
     *
     * @param TaskModel $taskModel Object Task Model
     */
    public function __construct(TaskModel $taskModel)
    {
        $this->taskModel = $taskModel;
    }

    /**
     * Function get all tasks
     *
     * @return void
     */
    public function index()
    {
        $tasks = $this->taskModel->findAllTask();

        return returnResponseJson("success", "", $tasks);
    }

    /**
     * Function post create task
     *
     * @return void
     */
    public function create()
    {
        $taskId = $this->taskModel->insertTask($_POST);
        
        $status = "success";

        if (!$taskId) {
            $status = "error";
        }

        return returnResponseJson($status, "", ['id' => $taskId]);
    }

    /**
     * Function post update task
     *
     * @param int $id Id of task
     *
     * @return void
     */
    public function update(int $id)
    {
        $taskId = $this->taskModel->updateTaskById($id, $_POST);
        
        $status = "success";

        if (!$taskId) {
            $status = "error";
        }

        return returnResponseJson($status, "", []);
    }

    /**
     * Function post delete task
     *
     * @param int $id Id of task
     *
     * @return void
     */
    public function delete(int $id)
    {
        $taskId = $this->taskModel->deleteTaskById($id);
        
        $status = "success";

        if (!$taskId) {
            $status = "error";
        }

        return returnResponseJson($status, "", []);
    }
}
