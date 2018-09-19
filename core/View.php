<?php

/**
 * This file is part of the binhdq/apptodo core
 * Handle view
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace Core;

class View
{
    protected $data;

    protected $path;

    /**
     * Function constructor
     *
     * @param string $path The path to file view
     * @param array  $data The data to use in file view
     */
    public function __construct(string $path, array $data = [])
    {
        $path = $this->getFullPath($path);

        if (!file_exists($path)) {
            throw new Exception('Template file is not found in path ' . $path);
        }
        
        $this->path = $path;
        $this->data = $data;
    }

    /**
     * Get the full path to file view
     *
     * @param string $path The path to file view
     *
     * @return string
     */
    public function getFullPath($path)
    {
        return config('view.path') . DS . $path . '.' . config('view.extension');
    }

    /**
     * Used to render view
     *
     * @return string
     */
    public function render()
    {
        $data = $this->data;

        ob_start();
        include $this->path;
        $content = ob_get_clean();

        return $content;
    }
}
