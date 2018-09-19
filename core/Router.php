<?php

/**
 * This file is part of the binhdq/apptodo core
 * Handle route when receive request from client
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace Core;

class Router
{
    const DEFAULT_CONTROLLER = 'home';
    const DEFAULT_ACTION = 'index';
    
    protected $controller;

    protected $action;

    protected $params;

    /**
     * Function constructor
     *
     * @param String $uri The part of url
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;
        $this->parseUri($uri);
    }

    /**
     * Function format uri, remove some character is wrong
     *
     * @param String $uri The part of url
     *
     * @return string
     */
    public function formatUri($uri)
    {
        if (!$uri) {
            return "";
        }

        $uri = urldecode(trim($uri, '/'));

        $uri = explode('?', $uri);

        return $uri[0];
    }

    /**
     * Parase the uri to controller, action and params
     *
     * @param String $uri The part of url
     *
     * @return void
     */
    protected function parseUri($uri)
    {
        $uri = $this->formatUri($uri);
        $controller = self::DEFAULT_CONTROLLER;
        $action = self::DEFAULT_ACTION;
        $params = [];
        
        $partsPath = explode('/', $uri);

        if ($uri != '' && count($partsPath)) {
            $controller = strtolower(current($partsPath));
            array_shift($partsPath);
            
            if (count($partsPath)) {
                $action = strtolower(current($partsPath));
                array_shift($partsPath);
                $params = $partsPath;
            }
        }

        $this->setController($controller);
        $this->setAction($action);
        $this->params = $params;
    }

    /**
     * Setting for controller
     *
     * @param String $controller The part to controller
     *
     * @return void
     */
    protected function setController($controller)
    {
        $controller = sprintf("\App\Controllers\%sController", ucfirst($controller));
        if (!class_exists($controller)) {
            throw new \Exception("Controller {$controller} not found!");
        }

        $this->controller = $controller;
    }

    /**
     * Setting for action in controller
     *
     * @param String $action The name of method in controller
     *
     * @return void
     */
    protected function setAction($action)
    {
        $reflector = new \ReflectionClass($this->controller);
        if (!$reflector->hasMethod($action)) {
            throw new \Exception("Controller {$this->controller} action: {$action} not found!");
        }

        $this->action = $action;
    }

    /**
     * Get value of controller
     *
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * Get value of action in controller
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Get params of action
     *
     * @return string
     */
    public function getParams()
    {
        return $this->params;
    }
}
