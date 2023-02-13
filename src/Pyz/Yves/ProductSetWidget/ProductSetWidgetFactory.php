<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductSetWidget;

use Spryker\Client\ProductSetStorage\ProductSetStorageClientInterface;
use Spryker\Client\ProductStorage\ProductStorageClientInterface;
use SprykerShop\Yves\ProductSetWidget\ProductSetWidgetFactory as SprykerProductSetWidgetFactory;

class ProductSetWidgetFactory extends SprykerProductSetWidgetFactory
{
    /**
     * @return \Spryker\Client\ProductStorage\ProductStorageClientInterface
     */
    public function getPyzProductStorageClient(): ProductStorageClientInterface
    {
        return $this->getProvidedDependency(ProductSetWidgetDependencyProvider::PYZ_CLIENT_PRODUCT_STORAGE);
    }

    /**
     * @return \Spryker\Client\ProductSetStorage\ProductSetStorageClientInterface
     */
    public function getPyzProductSetStorageClient(): ProductSetStorageClientInterface
    {
        return $this->getProvidedDependency(ProductSetWidgetDependencyProvider::PYZ_CLIENT_PRODUCT_SET_STORAGE);
    }
}
