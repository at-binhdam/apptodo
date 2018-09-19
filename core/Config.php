<?php

/**
 * This file is part of the binhdq/apptodo core
 * Handle get values from folder configs
 *
 * @author  Binhdq <binhdq92@gmail.com>
 * @license https://github.com/at-binhdam/apptodo App Todo
 */

namespace Core;

class Config
{
    /**
     * Get value config
     *
     * @param string $value The path to value to get
     *
     * @return string|array|int
     */
    public static function get($value)
    {
        $pathConfig = explode('.', $value);
        
        if (empty($pathConfig)) {
            return null;
        }
        
        $configFile = sprintf("%s/config/%s.php", ROOT, $pathConfig[0]);
        
        if (!file_exists($configFile)) {
            return null;
        }

        $dataConfig = include $configFile;
        
        $countPath = count($pathConfig);
        if ($countPath >= 2) {
            for ($i=1; $i < $countPath; $i++) {
                if (!isset($dataConfig[$pathConfig[$i]])) {
                    return null;
                }
                $dataConfig = $dataConfig[$pathConfig[$i]];
            }
            return $dataConfig;
        }

        return null;
    }
}
