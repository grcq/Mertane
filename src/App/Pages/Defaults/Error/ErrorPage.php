<?php

namespace App\Pages\Defaults\Error;

use App\Pages\Page;
use App\Request;
use App\Response\ResponseInterface;
use App\Response\RenderResponse;

class ErrorPage extends Page {

    public function index(Request $request): ?ResponseInterface
    {
        return $this->render("@Default.error/404.tpl");
    }

}