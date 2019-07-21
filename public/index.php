<?php

define('ROOT', dirname(dirname(__FILE__)));
require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

$router = new AltoRouter();

$router->map('GET', '/', ['c' => 'TaskController', 'a' => 'index'], 'home');
$router->map('GET', '/create', ['c' => 'TaskController', 'a' => 'create'], 'create');
$router->map('POST', '/store', ['c' => 'TaskController', 'a' => 'store'], 'store');
$router->map('GET', '/edit/[i:id]', ['c' => 'TaskController', 'a' => 'edit'], 'edit');
$router->map('POST', '/update/[i:id]', ['c' => 'TaskController', 'a' => 'update'], 'update');


$router->map('GET', '/login', ['c' => 'AuthController', 'a' => 'index'], 'login');
$router->map('POST', '/login', ['c' => 'AuthController', 'a' => 'store'], 'auth');
$router->map('GET', '/logout', ['c' => 'AuthController', 'a' => 'logout'], 'logout');
$match = $router->match();


if (is_array($match)
    && isset($match['target'])
    && is_callable('App\Controllers\\' . implode('::', $match['target']))) {

    $controllerName = 'App\Controllers\\' . $match['target']['c'];

    $controllerObject = new $controllerName;
    $actionName = $match['target']['a'];

    if (!method_exists($controllerObject, $actionName)) {
        header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
    }

    return $controllerObject->$actionName($match['params']);

} else {
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
