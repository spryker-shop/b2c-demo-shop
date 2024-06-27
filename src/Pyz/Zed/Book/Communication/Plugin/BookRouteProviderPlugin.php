<?php

namespace Pyz\Zed\Book\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\RouteProviderPluginInterface;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class BookRouteProviderPlugin extends AbstractPlugin implements RouteProviderPluginInterface
{
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection->add('book_index', new Route('/book', [
            '_controller' => 'Pyz\\Zed\\Book\\Communication\\Controller\\BookController::indexAction',
        ]));

        $routeCollection->add('book_create', new Route('/book/create', [
            '_controller' => 'Pyz\\Zed\\Book\\Communication\\Controller\\BookController::createAction',
        ]));

        $routeCollection->add('book_update', new Route('/book/update/{id}', [
            '_controller' => 'Pyz\\Zed\\Book\\Communication\\Controller\\BookController::updateAction',
        ]));

        $routeCollection->add('book_delete', new Route('/book/delete/{id}', [
            '_controller' => 'Pyz\\Zed\\Book\\Communication\\Controller\\BookController::deleteAction',
        ]));

        return $routeCollection;
    }
}
