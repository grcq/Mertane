<?php

namespace App\Response;

use App\Response\ResponseInterface;

class RedirectResponse implements ResponseInterface {

    public function __construct(string $path)
    {
        header("Location: " . $path);
        die();
    }

}