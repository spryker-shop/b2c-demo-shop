<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Business;

use Pyz\Zed\ExampleProductSalePage\Business\Label\ProductAbstractRelationReader;
use Pyz\Zed\ExampleProductSalePage\Business\Label\ProductAbstractRelationReaderInterface;
use Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageDependencyProvider;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Price\Business\PriceFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * @method \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig getConfig()
 */
class ExampleProductSalePageBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\ExampleProductSalePage\Business\Label\ProductAbstractRelationReaderInterface
     */
    public function createProductAbstractRelationReader(): ProductAbstractRelationReaderInterface
    {
        return new ProductAbstractRelationReader(
            $this->getQueryContainer(),
            $this->getConfig(),
            $this->getCurrencyFacade(),
            $this->getPriceFacade(),
            $this->getStoreFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\Currency\Business\CurrencyFacadeInterface
     */
    protected function getCurrencyFacade(): CurrencyFacadeInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::FACADE_CURRENCY);
    }

    /**
     * @return \Spryker\Zed\Price\Business\PriceFacadeInterface
     */
    protected function getPriceFacade(): PriceFacadeInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::FACADE_PRICE);
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::FACADE_STORE);
    }
}
