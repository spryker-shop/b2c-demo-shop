<?php
namespace Pyz\Zed\Book;

use Pyz\Zed\Book\Business\BookService;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Pyz\Zed\Book\BookConfig getConfig()
 */
class BookDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const BOOK_SERVICE = 'BOOK_SERVICE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container->set(static::BOOK_SERVICE, function (Container $container) {
            return new BookService();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        // Example: Add communication layer dependencies if needed in the future.
        // $container->set(static::SOME_DEPENDENCY, function (Container $container) {
        //     return new SomeDependencyBridge($container->getLocator()->someDependency()->facade());
        // });

        return $container;
    }
}
