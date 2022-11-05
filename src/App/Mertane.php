<?php

namespace App;

use App\Pages\Route;
use App\Container\Container;
use App\Container\DatabaseContainer;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Mertane {

    public static \Smarty $smarty;

    private string $name;

    private string $version;

    protected static array $pages = [];

    public function __construct(string $name, string $version) {
        $this->name = $name;
        $this->version = $version;

        static::$smarty = new \Smarty();
        static::$smarty->setCompileDir(ROOT_PATH . "/cache/templates_c")->setTemplateDir(ROOT_PATH . "/cache/templates");

        Container::registerContainer("database", new DatabaseContainer());
    }

    public function loadPage(string $pageRoute) {
        if (!isset(static::$pages[$pageRoute])) {
            echo "Error 404";
            return;
        }

        $page = static::$pages[$pageRoute];
        $request = new Request(explode("?", $_SERVER['REQUEST_URI'])[0], static::$smarty);
        $res = $page->index($request);
    }

    public function registerPage(string $class) {
        $page = new $class;

        AnnotationRegistry::registerLoader('class_exists');
        $reader = new AnnotationReader();
        
        $reflectionClass = new \ReflectionClass(Route::class);
        $reflectionMethod = new \ReflectionMethod($page::class, "index");
        $a = $reader->getMethodAnnotations($reflectionMethod)[0];

        static::$pages += ["$a->path" => $page];
    }

}