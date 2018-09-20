<?php

/**
 * This file is part of the binhdq/apptodo core
 * Create function common for system
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

if (!function_exists('dd')) {
    
    /**
     * Function dump data
     *
     * @param array   $data     Data to dump
     * @param boolean $flagStop The flag use to stop system
     *
     * @return void
     */
    function dd($data = null, $flagStop = true)
    {
        echo "<pre>";
        var_dump($data);

        if ($flagStop) {
            exit;
        }
    }
}

if (!function_exists('view')) {
    
    /**
     * Used to render view
     *
     * @param string $path The path to file view
     * @param array  $data Data use to show in file view
     *
     * @return void
     */
    function view(string $path, array $data = [])
    {
        $objView = new \Core\View($path, $data);
        echo $objView->render();
    }
}

if (!function_exists('config')) {

    /**
     * Used get value from file config
     *
     * @param string $value The path to value in file config
     *
     * @return array|string|int
     */
    function config(string $value)
    {
        return \Core\Config::get($value);
    }
}

if (!function_exists('registerObject')) {
    
    /**
     * Used to bind objects has DI when init the object
     *
     * @param string $pathClass The path to class
     *
     * @return object
     */
    function registerObject(string $pathClass)
    {
        $reflection = new \ReflectionClass($pathClass);
        $params = $reflection->getConstructor()->getParameters();
        $objsConstructor = [];
        
        for ($i = 0; $i < count($params); $i++) {
            $className = $params[$i]->getClass()->getName();
            $objsConstructor[] = new $className();
        }

        return new $pathClass(...$objsConstructor);
    }
}

if (!function_exists('returnResponseJson')) {

    /**
     * Return response with type json
     *
     * @param string $status  success|error
     * @param string $message Message
     * @param array  $data    List data
     *
     * @return void
     */
    function returnResponseJson(string $status, string $message, array $data = [])
    {
        header('Content-Type: application/json');

        echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
    }
}
