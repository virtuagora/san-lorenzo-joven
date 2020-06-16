<?php

namespace App\Util;

use Slim\Container;

abstract class ContainerClient
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function __get($key)
    {
        return $this->container->get($key);
    }
}
