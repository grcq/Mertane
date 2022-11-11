<?php

namespace App;

use App\Pages\Page;
use App\Pages\Route;
use App\Container\Container;
use App\Container\EntityContainer;
use App\Container\DatabaseContainer;
use App\Container\ConfigurationContainer;
use Pages\Error\ErrorPage;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Mertane {

    public static \Smarty $smarty;

    private string $name;

    private string $version;

    private Container $container;

    private ?Page $errorPage;

    protected static array $pages = [];

    public function __construct(string $name, string $version) 
    {
        $this->name = $name;
        $this->version = $version;

        $this->container = Container::init();

        $this->setErrorPage(new ErrorPage());

        static::$smarty = new \Smarty();
        static::$smarty->setCompileDir(ROOT_PATH . "/cache/templates_c")->setTemplateDir(ROOT_PATH . "/cache/templates");

        $this->container->registerContainer("database", new DatabaseContainer());
        $this->container->registerContainer("entity", new EntityContainer());
        $this->container->registerContainer("config", new ConfigurationContainer());
    }

    public function loadPage(string $pageRoute) 
    {
        if (!isset(static::$pages[$pageRoute])) 
        {
            $this->errorPage->index(new Request(explode("?", $_SERVER['REQUEST_URI'])[0], static::$smarty));
            return;
        }

        $page = static::$pages[$pageRoute];
        $request = new Request(explode("?", $_SERVER['REQUEST_URI'])[0], static::$smarty);
        $res = $page->index($request);
    }

    public function registerPage(string $class) 
    {
        $page = new $class;

        AnnotationRegistry::registerLoader('class_exists');
        $reader = new AnnotationReader();
        
        $reflectionClass = new \ReflectionClass(Route::class);
        $reflectionMethod = new \ReflectionMethod($page::class, "index");
        $a = $reader->getMethodAnnotations($reflectionMethod)[0];

        static::$pages += ["$a->path" => $page];
    }

    public final function setErrorPage(Page $page): void
    {
        $this->errorPage = $page;
    }

    public final function getErrorPage(): ?Page
    {
        return $this->errorPage;
    }

}