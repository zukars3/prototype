<?php

use App\Core\Config\ConfigManager;
use App\Core\Config\FileConfig;

function config(): ConfigManager
{
    $config = include(__DIR__ . '/config/config.php');
    return new FileConfig($config);
}