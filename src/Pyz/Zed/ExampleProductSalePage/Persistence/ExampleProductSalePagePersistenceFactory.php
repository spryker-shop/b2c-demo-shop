<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Persistence;

use Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageDependencyProvider;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\Product\Persistence\ProductQueryContainerInterface;
use Spryker\Zed\ProductLabel\Persistence\ProductLabelQueryContainerInterface;

/**
 * @method \Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig getConfig()
 * @method \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface getQueryContainer()
 */
class ExampleProductSalePagePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Spryker\Zed\ProductLabel\Persistence\ProductLabelQueryContainerInterface
     */
    public function getProductLabelQueryContainer(): ProductLabelQueryContainerInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::QUERY_CONTAINER_PRODUCT_LABEL);
    }

    /**
     * @return \Spryker\Zed\Product\Persistence\ProductQueryContainerInterface
     */
    public function getProductQueryContainer(): ProductQueryContainerInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::QUERY_CONTAINER_PRODUCT);
    }
}
