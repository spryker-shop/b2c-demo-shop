<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductStorage\Business;

use Pyz\Zed\ProductStorage\Business\Storage\ProductAbstractStorageWriter;
use Spryker\Zed\ProductStorage\Business\ProductStorageBusinessFactory as SprykerProductStorageBusinessFactory;
use Spryker\Zed\ProductStorage\ProductStorageDependencyProvider;

/**
 * @method \Spryker\Zed\ProductStorage\ProductStorageConfig getConfig()
 * @method \Pyz\Zed\ProductStorage\Persistence\ProductStorageQueryContainerInterface getQueryContainer()
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
            $this->getConfig()->isSendingToQueue()
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
