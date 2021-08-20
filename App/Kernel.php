<?php

namespace App;

use App\Config\Config;
use App\DI\Container;

class Kernel
{
    /**
     * @var Container
     */
    private $container;

    private $config;

    public function __construct()
    {
        $configDir = 'config';
        $config = new Config();
        $config->parse($configDir);


    }

    public function run()
    {
        
    }
}