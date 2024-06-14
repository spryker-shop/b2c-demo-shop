<?php

use Spryker\Zed\Router\Business\Route\RouteCollection;

return function (RouteCollection $routeCollection) {
    $route = $routeCollection->addGet('/book', 'Book', 'indexAction');
    $route->setMethods(['GET']);

    $route = $routeCollection->addGet('/book/create', 'Book', 'createAction');
    $route->setMethods(['GET', 'POST']);

    $route = $routeCollection->addGet('/book/update/{id}', 'Book', 'updateAction');
    $route->setMethods(['GET', 'POST']);
    $route->setRequirements(['id' => '\d+']);

    $route = $routeCollection->addGet('/book/delete/{id}', 'Book', 'deleteAction');
    $route->setMethods(['GET']);
    $route->setRequirements(['id' => '\d+']);
};
