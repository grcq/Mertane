<?php

namespace App\Exceptions;

class Exception extends \Exception {

    public function __construct($message, $val = 0, \Exception $old = null) {
        parent::__construct($message, $val, $old);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function custFunc() {
        echo "Insert any custom message here\n";
    }

}