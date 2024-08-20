<?php
namespace Pyz\Zed\Book;

use Pyz\Zed\Book\Business\BookFacade;
use Pyz\Zed\Book\Persistence\BookEntityManager;
use Pyz\Zed\Book\Persistence\BookRepository;
use Pyz\Zed\Book\Persistence\BookEntityManagerInterface;
use Pyz\Zed\Book\Persistence\BookRepositoryInterface;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Pyz\Zed\Book\Communication\BookCommunicationFactory;
use Spryker\Zed\Kernel\Communication\Plugin\Router\RouterPluginInterface;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Spryker\Zed\Router\RouterDependencyProvider as SprykerRouterDependencyProvider;

class BookDependencyProvider extends AbstractBundleDependencyProvider
{
    public const ENTITY_MANAGER_BOOK = 'ENTITY_MANAGER_BOOK';
    public const REPOSITORY_BOOK = 'REPOSITORY_BOOK';
    // public const ENTITY_MANAGER_BOOK = 'ENTITY_MANAGER';
    // public const REPOSITORY_BOOK = 'REPOSITORY';

    public function provideBusinessLayerDependencies(Container $container): void
    {
        $this->addRouterResourcePlugins($container);

        $container = parent::provideBusinessLayerDependencies($container);

        // $container[static::ENTITY_MANAGER_BOOK] = function (Container $container) {
        $container[self::ENTITY_MANAGER_BOOK] = function (Container $container): BookEntityManagerInterface {
            return new BookEntityManager();
        };

        // $container[static::REPOSITORY_BOOK] = function (Container $container) {
        $container[self::REPOSITORY_BOOK] = function (Container $container): BookRepositoryInterface {
            return new BookRepository();
        };

        // return $container;
    }

    protected function addRouterResourcePlugins(Container $container)
    {
        $container[RouterPluginInterface::class] = function (Container $container) {
            return [
                new ZedRouterResourcePlugin(),
                $this->createBookRouterResourcePlugin(),
            ];
        };

        return $container;
    }

    public function provideCommunicationLayerDependencies(Container $container)
    {
        parent::provideCommunicationLayerDependencies($container);
    }
}
