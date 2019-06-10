<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage;

use Spryker\Client\ProductQuantityStorage\ProductQuantityStorageClientInterface;
use SprykerShop\Yves\CartPage\CartPageFactory as SprykerCartPageFactory;

class CartPageFactory extends SprykerCartPageFactory
{
    /**
     * @return \Spryker\Client\ProductQuantityStorage\ProductQuantityStorageClientInterface
     */
    public function getProductQuantityStorageClient(): ProductQuantityStorageClientInterface
    {
        return $this->getProvidedDependency(CartPageDependencyProvider::CLIENT_PRODUCT_QUANTITY_STORAGE);
    }
}
