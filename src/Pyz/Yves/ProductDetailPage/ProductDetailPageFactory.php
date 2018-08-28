<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ProductDetailPage;

use Spryker\Client\ProductStorage\ProductStorageClientInterface;
use SprykerShop\Yves\ProductDetailPage\ProductDetailPageFactory as SprykerProductDetailPageFactory;

class ProductDetailPageFactory extends SprykerProductDetailPageFactory
{

    /**
     * @return \Spryker\Client\ProductStorage\ProductStorageClientInterface
     */
    public function getProductStoragePyzClient(): ProductStorageClientInterface
    {
        return $this->getProvidedDependency(ProductDetailPageDependencyProvider::CLIENT_PRODUCT_STORAGE_PYZ);
    }
}
