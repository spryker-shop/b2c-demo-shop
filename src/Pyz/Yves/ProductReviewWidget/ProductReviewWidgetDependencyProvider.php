<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\ProductReviewWidget;

use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetDependencyProvider as SprykerProductReviewWidgetDependencyProvider;

class ProductReviewWidgetDependencyProvider extends SprykerProductReviewWidgetDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_GLOSSARY_STORAGE = 'CLIENT_GLOSSARY_STORAGE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $this->addGlossaryStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addGlossaryStorageClient(Container $container): Container
    {
        $container->set(static::CLIENT_GLOSSARY_STORAGE, function (Container $container) {
            return $container->getLocator()->glossaryStorage()->client();
        });

        return $container;
    }
}
