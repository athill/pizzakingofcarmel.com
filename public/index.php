<?php
require(__DIR__ . '/../vendor/autoload.php');

require(__DIR__ . '/../app/bootstrap.php');

use App\Router;

$uri = $_SERVER['REQUEST_URI'];

if (preg_match("/^\/(api|export)(\/.*)?/", $uri)) {
  $router = new Router();
  $router->route();
  exit(0);
}

readfile(__DIR__ . '/index.html');


