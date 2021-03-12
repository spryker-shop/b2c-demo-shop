<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\CombinedProduct\ProductConcrete\Writer;

use Pyz\Zed\DataImport\Business\CombinedProduct\ProductConcrete\CombinedProductConcreteHydratorStep;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\ProductConcretePropelDataSetWriter;

class CombinedProductConcretePropelDataSetWriter extends ProductConcretePropelDataSetWriter
{
    protected const COLUMN_ABSTRACT_SKU = CombinedProductConcreteHydratorStep::COLUMN_ABSTRACT_SKU;

    /**
     * @param \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct($productRepository);
    }
}
