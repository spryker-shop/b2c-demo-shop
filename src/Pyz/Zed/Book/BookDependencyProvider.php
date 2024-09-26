<?php

namespace Pyz\Zed\Book;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class BookDependencyProvider extends AbstractBundleDependencyProvider
{
    public function provideBusinessLayerDependencies(Container $container)
    {
        // Add any business layer dependencies here
        return $container;
    }

    public function provideCommunicationLayerDependencies(Container $container)
    {
        // Add any communication layer dependencies here
        return $container;
    }

    public function providePersistenceLayerDependencies(Container $container)
    {
        // Add any persistence layer dependencies here
        return $container;
    }

    public function providePresentationLayerDependencies(Container $container)
    {
        // Add any presentation layer dependencies here
        return $container;
    }
}
