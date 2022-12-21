<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductReviewWidget;

use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetDependencyProvider as SprykerProductReviewWidgetDependencyProvider;

class ProductReviewWidgetDependencyProvider extends SprykerProductReviewWidgetDependencyProvider
{
    /**
     * @var string
     */
    public const PYZ_CLIENT_GLOSSARY_STORAGE = 'PYZ_CLIENT_GLOSSARY_STORAGE';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $this->addPyzGlossaryStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addPyzGlossaryStorageClient(Container $container): Container
    {
        $container->set(static::PYZ_CLIENT_GLOSSARY_STORAGE, function (Container $container) {
            return $container->getLocator()->glossaryStorage()->client();
        });

        return $container;
    }
}
