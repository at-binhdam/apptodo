<?php

/**
 * This file is part of the binhdq/apptodo core
 * Run application
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace Core;

class App
{
    protected $objController;

    /**
     * Function constructor
     */
    public function __construct()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $router = new Router($uri);
        $this->objController = new Controller($router);
    }
    
    /**
     * Run application
     *
     * @return void
     */
    public function run()
    {
        $this->objController->init();
    }
}
