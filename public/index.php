<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__DIR__) . '/vendor/autoload.php';

define("ROOT_PATH", dirname(__DIR__));
define("VERSION", "1.0.0");
define("NAME", "Dev");

use App\Mertane;
use Pages\Error\ErrorPage;

$mertane = new Mertane(NAME, VERSION);
$mertane->registerPage("Pages\\HomePage");

$mertane->loadPage($_SERVER['REQUEST_URI']);

return $mertane;