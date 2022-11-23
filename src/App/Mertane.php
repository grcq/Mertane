<?php

namespace App;

use App\Pages\Page;
use App\Pages\Route;
use App\Pages\Defaults\Error\ErrorPage;
use App\Exceptions\Exception;
use App\Container\Container;
use App\Container\EntityContainer;
use App\Container\DatabaseContainer;
use App\Container\ConfigurationContainer;
use App\Container\CacheContainer;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

class Mertane {

    private static \Smarty $smarty;

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
        $this->container->registerContainer("cache", new CacheContainer());
    }

    public function loadPage(string $pageRoute, $data = []) 
    {
        $a = explode(".", $pageRoute);
        if ($a[count($a) - 1] == "css") 
        {
            echo file_get_contents($pageRoute);
            header("Content-type: text/css");
            return;
        }

        if (!isset(static::$pages[$pageRoute])) 
        {
            $this->errorPage->index(new Request($data, explode("?", $_SERVER['REQUEST_URI'])[0], static::$smarty));
            return;
        }

        try {
            $page = static::$pages[$pageRoute];
            if ($page == null) throw new Exception("");

            static::$smarty->assign("ROOT_PATH", ROOT_PATH);
            static::$smarty->assign("LINKS", $page->getStyles());

            $request = new Request($data, explode("?", $_SERVER['REQUEST_URI'])[0], static::$smarty);
            $res = $page->index($request);
        } catch (\Throwable $e) {
            $vars = [
                "error" => $e->getMessage(),
                "code" => $e->getCode(),
                "file" => $e->getFile(),
                "line" => $e->getLine(),
                "trace" => $e->getTrace(),
                "traceString" => $e->getTraceAsString(),
                "class" => get_class($e)
            ];
            $this->loadPage("/test", $vars);
        }
    }

    public function registerPage($class) 
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

    public static function setSmarty(\Smarty $smarty): void
    {
        static::$smarty = $smarty;
    }

    public static function getSmarty(): \Smarty
    {
        return static::$smarty;
    }

}