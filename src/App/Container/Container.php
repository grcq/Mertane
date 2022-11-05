<?php

namespace App\Container;

use App\Container\DatabaseContainer;

class Container {

    private static array $containers = [];
    private static ?Container $container = null;

    public final function get(string $container): ?Container
    {
        return (isset(static::$containers[$container]) ? static::$containers[$container] : null);
    }

    public static final function registerContainer(string $name, Container $container): void
    {
        static::$containers += ["$name" => $container];
    }

    public static function init(): Container
    {
        if (isset(static::$container) || static::$container != null) return static::$container;

        static::$container = new Container();
        return static::$container;
    }

}