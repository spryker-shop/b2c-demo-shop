<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CartPage;

use Pyz\Yves\CartPage\RestrictionsSetter\QuantityRestrictionsSetter;
use Pyz\Yves\CartPage\RestrictionsSetter\QuantityRestrictionsSetterInterface;
use Spryker\Client\ProductQuantityStorage\ProductQuantityStorageClientInterface;
use SprykerShop\Yves\CartPage\CartPageFactory as SprykerCartPageFactory;

class CartPageFactory extends SprykerCartPageFactory
{
    /**
     * @return \Pyz\Yves\CartPage\RestrictionsSetter\QuantityRestrictionsSetterInterface
     */
    public function createQuantityRestrictionsSetter(): QuantityRestrictionsSetterInterface
    {
        return new QuantityRestrictionsSetter($this->getProductQuantityStorageClient());
    }

    /**
     * @return \Spryker\Client\ProductQuantityStorage\ProductQuantityStorageClientInterface
     */
    public function getProductQuantityStorageClient(): ProductQuantityStorageClientInterface
    {
        return $this->getProvidedDependency(CartPageDependencyProvider::CLIENT_PRODUCT_QUANTITY_STORAGE);
    }
}
