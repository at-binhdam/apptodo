<?php

ini_set('display_errors', 1);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

$app = require_once ROOT . DS . 'bootstrap' . DS . 'app.php';

$app->run();
