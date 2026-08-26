<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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

    protected function getCurrencyFacade(): CurrencyFacadeInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::FACADE_CURRENCY);
    }

    protected function getPriceFacade(): PriceFacadeInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::FACADE_PRICE);
    }

    protected function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(ExampleProductSalePageDependencyProvider::FACADE_STORE);
    }
}
