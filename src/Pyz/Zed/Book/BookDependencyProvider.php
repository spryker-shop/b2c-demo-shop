<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book;

use Pyz\Zed\Book\Dependency\Facade\BookToStoreFacadeBridge;
use Pyz\Zed\Book\Dependency\Facade\BookToLocaleFacadeBridge;
use Pyz\Zed\Book\Dependency\Plugin\BookPreSavePluginInterface;
use Pyz\Zed\Book\Dependency\Plugin\BookPostSavePluginInterface;
use Pyz\Zed\Book\Dependency\Plugin\BookPostCreatePluginInterface;
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
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @var string
     */
    public const FACADE_LOCALE = 'FACADE_LOCALE';

    /**
     * @var string
     */
    public const BOOK_PRE_SAVE_PLUGINS = 'BOOK_PRE_SAVE_PLUGINS';

    /**
     * @var string
     */
    public const BOOK_POST_SAVE_PLUGINS = 'BOOK_POST_SAVE_PLUGINS';

    /**
     * @var string
     */
    public const BOOK_POST_CREATE_PLUGINS = 'BOOK_POST_CREATE_PLUGINS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addStoreFacade($container);
        $container = $this->addLocaleFacade($container);
        $container = $this->addBookPreSavePlugins($container);
        $container = $this->addBookPostSavePlugins($container);
        $container = $this->addBookPostCreatePlugins($container);

        return $container;
    }

    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addLocaleFacade($container);
        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return $container->getLocator()->store()->facade();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addLocaleFacade(Container $container): Container
    {
        $container->set(static::FACADE_LOCALE, function (Container $container) {
            return  $container->getLocator()->locale()->facade();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addBookPreSavePlugins(Container $container): Container
    {
        $container->set(static::BOOK_PRE_SAVE_PLUGINS, function () {
            return $this->getBookPreSavePlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addBookPostSavePlugins(Container $container): Container
    {
        $container->set(static::BOOK_POST_SAVE_PLUGINS, function () {
            return $this->getBookPostSavePlugins();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addBookPostCreatePlugins(Container $container): Container
    {
        $container->set(static::BOOK_POST_CREATE_PLUGINS, function () {
            return $this->getBookPostCreatePlugins();
        });

        return $container;
    }

    /**
     * @return array<\Pyz\Zed\Book\Dependency\Plugin\BookPreSavePluginInterface>
     */
    protected function getBookPreSavePlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Pyz\Zed\Book\Dependency\Plugin\BookPostSavePluginInterface>
     */
    protected function getBookPostSavePlugins(): array
    {
        return [];
    }

    /**
     * @return array<\Pyz\Zed\Book\Dependency\Plugin\BookPostCreatePluginInterface>
     */
    protected function getBookPostCreatePlugins(): array
    {
        return [];
    }
}
