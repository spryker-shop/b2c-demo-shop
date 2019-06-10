<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage;

use Spryker\Yves\Kernel\Container;
use SprykerShop\Yves\CartPage\CartPageDependencyProvider as SprykerCartPageDependencyProvider;
use SprykerShop\Yves\ProductBundleWidget\Plugin\CartPage\ProductBundleCartItemTransformerPlugin;

class CartPageDependencyProvider extends SprykerCartPageDependencyProvider
{
    public const CLIENT_PRODUCT_QUANTITY_STORAGE = 'CLIENT_PRODUCT_QUANTITY_STORAGE';

    /**
     * @return \SprykerShop\Yves\CartPage\Dependency\Plugin\CartItemTransformerPluginInterface[]
     */
    protected function getCartItemTransformerPlugins(): array
    {
        return [
            new ProductBundleCartItemTransformerPlugin(),
        ];
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = parent::provideDependencies($container);
        $container = $this->addProductQuantityStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductQuantityStorageClient(Container $container): Container
    {
        $container[static::CLIENT_PRODUCT_QUANTITY_STORAGE] = function (Container $container) {
            return $container->getLocator()->productQuantityStorage()->client();
        };

        return $container;
    }
}
