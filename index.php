<?php

require_once __DIR__ . '/vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router) {
    $router->addRoute('GET', '/', 'ApplicationsController@index');
    $router->addRoute('POST', '/application/create', 'ApplicationsController@create');
    $router->addRoute('GET', '/partner/applications', 'ApplicationsController@partners');
    $router->addRoute('POST', '/partner/applications/offer', 'ApplicationsController@offer');
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $params = $routeInfo[2];

        [$controller, $method] = explode('@', $handler);

        $controllerPath = '\App\Controllers\\' . $controller;
        echo (new $controllerPath)->{$method}($params);

        break;
}