<?php

namespace Pyz\Zed\Book;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Yves\Form\FormFactory;
use Pyz\Zed\Book\Communication\Plugin\BookRouteProviderPlugin;
use Spryker\Zed\Router\RouterDependencyProvider;

class BookDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FORM_FACTORY = 'FORM_FACTORY';

    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container[static::FORM_FACTORY] = function (Container $container) {
            return new FormFactory();
        };
        $container[RouterDependencyProvider::ROUTER_PLUGINS] = function (Container $container) {
            return [
                new BookRouteProviderPlugin(),
            ];
        };
        return $container;
    }
}
