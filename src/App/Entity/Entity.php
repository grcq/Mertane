<?php

namespace App\Entity;

use App\Container\Container;

abstract class Entity {

    private Container $container;

    public function __construct()
    {
        $this->container = Container::init();
    }

    public abstract function update(): void;

}