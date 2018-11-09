<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Persistence;

use Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageDependencyProvider;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Spryker\Zed\ProductNew\ProductNewConfig getConfig()
 * @method \Spryker\Zed\ProductNew\Persistence\ProductNewQueryContainer getQueryContainer()
 */
class ExampleProductSalePagePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Spryker\Zed\ProductLabel\Persistence\ProductLabelQueryContainerInterface
     */
    public function getProductLabelQueryContainer()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::QUERY_CONTAINER_PRODUCT_LABEL);
    }

    /**
     * @return \Spryker\Zed\Product\Persistence\ProductQueryContainerInterface
     */
    public function getProductQueryContainer()
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::QUERY_CONTAINER_PRODUCT);
    }
}
