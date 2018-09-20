<?php

/**
 * This file is part of the application
 * Home Controller
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace App\Controllers;

use App\Models\TaskModel;

class HomeController
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
     * Action index
     *
     * @return void
     */
    public function index()
    {
        return view('home');
    }
}
