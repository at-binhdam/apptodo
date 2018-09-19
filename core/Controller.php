<?php

/**
 * This file is part of the binhdq/apptodo core
 * Hanlde routing a request to the controller
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace Core;

class Controller
{
    protected $router;
    
    /**
     * Function constructor
     *
     * @param Router $router Object router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    /**
     * Routing a request to the controller
     *
     * @return void
     */
    public function init()
    {
        $controller = $this->router->getController();
        $action = $this->router->getAction();
        $params = $this->router->getParams();

        $objController = registerObject($controller);

        call_user_func_array([$objController, $action], $params);
    }
}
