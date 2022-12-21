<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductStock\Writer;

use Pyz\Zed\DataImport\Business\CombinedProduct\ProductStock\CombinedProductStockHydratorStep;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\ProductStockPropelDataSetWriter;
use Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface;
use Spryker\Zed\Stock\Business\StockFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class CombinedProductStockPropelDataSetWriter extends ProductStockPropelDataSetWriter
{
    protected const COLUMN_CONCRETE_SKU = CombinedProductStockHydratorStep::COLUMN_CONCRETE_SKU;

    protected const COLUMN_IS_BUNDLE = CombinedProductStockHydratorStep::COLUMN_IS_BUNDLE;

    protected const COLUMN_IS_NEVER_OUT_OF_STOCK = CombinedProductStockHydratorStep::COLUMN_IS_NEVER_OUT_OF_STOCK;

    /**
     * @param \Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface $productBundleFacade
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface $productRepository
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     * @param \Spryker\Zed\Stock\Business\StockFacadeInterface $stockFacade
     */
    public function __construct(
        ProductBundleFacadeInterface $productBundleFacade,
        ProductRepositoryInterface $productRepository,
        StoreFacadeInterface $storeFacade,
        StockFacadeInterface $stockFacade
    ) {
        parent::__construct($productBundleFacade, $productRepository, $storeFacade, $stockFacade);
    }
}
