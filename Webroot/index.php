<?php
namespace MVC\Webroot;

use MVC\Router;
use MVC\Request;
use MVC\Dispatcher;

require_once '../vendor/autoload.php';

define('WEBROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("Webroot/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

require(ROOT . 'Config/core.php');

$dispatch = new Dispatcher();
$dispatch->dispatch();

?>
