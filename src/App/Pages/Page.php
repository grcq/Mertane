<?php

namespace App\Pages;

use App\Mertane;
use App\Request;
use App\Response\ResponseInterface;
use App\Response\RedirectResponse;
use App\Response\RenderResponse;
use App\Container\Container;

abstract class Page {

    private Container $container;
    private array $styles;

    public final function __construct()
    {
        $this->container = Container::init();
        $this->styles = [];
    }
    
    abstract public function index(Request $request): ?ResponseInterface;

    public final function redirect(string $path): RedirectResponse
    {
        return new RedirectResponse($path);
    }

    public final function render(string $fileName): RenderResponse
    {
        return new RenderResponse($fileName);
    }

    public final function addStyle(string $file): void
    {
        $path = ROOT_PATH . "/src/Resources/" . $fileName;
        if (strlen($fileName) >= strlen("@Default."))
        {
            if (substr($fileName, 0, strlen("@Default.")) == "@Default.")
            {
                $path = ROOT_PATH . "/src/App/Pages/Defaults/Resources/styles/" . substr($fileName, strlen("@Default."), strlen($fileName));
            }
        }

        array_push($this->styles, $path);
    }

    public function getStyles(): array
    {
        return $this->styles;
    }

}