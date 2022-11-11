<?php

namespace App\Container;

use App\Container\Container;

class ConfigurationContainer extends Container {

    private string $configFile;

    public function __construct()
    {
        $this->configFile = ROOT_PATH . "/config.json";
    }

    public function fetch(string $variable): mixed
    {
        $config = json_decode(file_get_contents($this->configFile), true);
        $path = explode('/', $variable);

        $val = &$config;

        $x = count($path) - 1;
        if ($x == 0) {
           return $val[$path[0]];
        }

        $loc = &$config;
        foreach ($path as $step) {
            $loc = &$loc[$step];
        }
        
        return $loc;
    }

    public function set(string $variable, $value): void
    {
        $config = json_decode(file_get_contents($this->configFile), true);
        $path = explode('/', $variable);

        $val = &$config;

        $x = count($path) - 1;
        if ($x == 0) {
            $val[$path[0]] = $value;
        } else {
            $loc = &$config;
            foreach ($path as $step) {
                $loc = &$loc[$step];
            }
            $loc = $value;
        }

        $json = json_encode($val, JSON_PRETTY_PRINT);
        file_put_contents($file, $json);
    }

}