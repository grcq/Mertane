<?php

namespace App\Pages;

use App\Request;
use App\Response\ResponseInterface;
use App\Response\RedirectResponse;
use App\Response\RenderResponse;

abstract class Page {
    
    abstract public function index(Request $request): ?ResponseInterface;

    public final function redirect(string $path): RedirectResponse
    {
        return new RedirectResponse($path);
    }

    public final function render(string $fileName): RenderResponse
    {
        return new RenderResponse($fileName);
    }

}