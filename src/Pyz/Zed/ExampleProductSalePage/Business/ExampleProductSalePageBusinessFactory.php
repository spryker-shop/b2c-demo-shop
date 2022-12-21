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

/**
 * @method \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig getConfig()
 */
class ExampleProductSalePageBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\ExampleProductSalePage\Business\Label\ProductAbstractRelationReaderInterface
     */
    public function createPyzProductAbstractRelationReader(): ProductAbstractRelationReaderInterface
    {
        return new ProductAbstractRelationReader(
            $this->getQueryContainer(),
            $this->getConfig(),
            $this->getPyzCurrencyFacade(),
            $this->getPyzPriceFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\Currency\Business\CurrencyFacadeInterface
     */
    protected function getPyzCurrencyFacade(): CurrencyFacadeInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_FACADE_CURRENCY);
    }

    /**
     * @return \Spryker\Zed\Price\Business\PriceFacadeInterface
     */
    protected function getPyzPriceFacade(): PriceFacadeInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::PYZ_FACADE_PRICE);
    }
}
