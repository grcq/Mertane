<?php

namespace App\Container;

use App\Container\Container;

class DatabaseContainer extends Container {

    public function hi() 
    {
        echo "AA";
    }

    public function e(): string
    {
        return "nn";
    }

}