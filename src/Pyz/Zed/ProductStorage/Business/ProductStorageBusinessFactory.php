<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductStorage\Business;

use Pyz\Zed\ProductStorage\Business\Storage\ProductAbstractStorageWriter;
use Pyz\Zed\ProductStorage\Business\Storage\ProductConcreteStorageWriter;
use Spryker\Zed\ProductStorage\Business\Attribute\AttributeMap;
use Spryker\Zed\ProductStorage\Business\ProductStorageBusinessFactory as SprykerProductStorageBusinessFactory;
use Spryker\Zed\ProductStorage\ProductStorageDependencyProvider;

/**
 * @method \Spryker\Zed\ProductStorage\ProductStorageConfig getConfig()
 * @method \Spryker\Zed\ProductStorage\Persistence\ProductStorageQueryContainerInterface getQueryContainer()
 */
class ProductStorageBusinessFactory extends SprykerProductStorageBusinessFactory
{
    /**
     * @return \Spryker\Zed\ProductStorage\Business\Storage\ProductAbstractStorageWriterInterface
     */
    public function createProductAbstractStorageWriter()
    {
        return new ProductAbstractStorageWriter(
            $this->getProductFacade(),
            $this->createAttributeMap(),
            $this->getQueryContainer(),
            $this->getStoreFacade(),
            $this->getConfig()->isSendingToQueue(),
            $this->getProductAbstractStorageExpanderPlugins()
        );
    }

    /**
     * @return \Spryker\Zed\ProductStorage\Business\Storage\ProductConcreteStorageWriterInterface
     */
    public function createProductConcreteStorageWriter()
    {
        return new ProductConcreteStorageWriter(
            $this->getProductFacade(),
            $this->getQueryContainer(),
            $this->getConfig()->isSendingToQueue()
        );
    }

    /**
     * @return \Spryker\Zed\ProductStorage\Business\Attribute\AttributeMapInterface
     */
    protected function createAttributeMap()
    {
        return new AttributeMap(
            $this->getProductFacade(),
            $this->getQueryContainer()
        );
    }

    /**
     * @return \Spryker\Zed\ProductStorage\Dependency\Facade\ProductStorageToProductBridge
     */
    protected function getProductFacade()
    {
        return $this->getProvidedDependency(ProductStorageDependencyProvider::FACADE_PRODUCT);
    }
}
