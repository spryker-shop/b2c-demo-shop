<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductAttributeGui\Communication;

use Pyz\Zed\ProductAttributeGui\ProductAttributeGuiConfig;
use Pyz\Zed\ProductAttributeGui\ProductAttributeGuiDependencyProvider;
use Spryker\Zed\ProductAttributeGui\Communication\ProductAttributeGuiCommunicationFactory as SpyFactory;

/**
 * @method \Spryker\Zed\ProductAttributeGui\ProductAttributeGuiConfig getConfig()
 */
class ProductAttributeGuiCommunicationFactory extends SpyFactory
{

    /**
     * @return \Pyz\Zed\ProductAttributeGui\Dependency\Facade\ProductAttributeGuiToProductInterface
     */
    public function getProductFacade()
    {
        return $this->getProvidedDependency(ProductAttributeGuiDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \Pyz\Zed\ProductAttributeGui\ProductAttributeGuiConfig
     */
    public function getConfig()
    {
        return new ProductAttributeGuiConfig();
    }
}
