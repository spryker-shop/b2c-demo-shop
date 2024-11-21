<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetail\Business\Manager;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductResponseTransfer;
use Pyz\Zed\ProductDetail\Persistence\ProductDetailEntityManagerInterface;
use Pyz\Zed\ProductDetail\Persistence\ProductDetailRepositoryInterface;

class ProductDetailManager implements ProductDetailManagerInterface
{
    /**
     * @var \Pyz\Zed\ProductDetail\Persistence\ProductDetailRepositoryInterface
     */
    protected $productDetailRepository;

    /**
     * @var \Pyz\Zed\ProductDetail\Persistence\ProductDetailEntityManagerInterface
     */
    protected $productDetailEntityManager;

    /**
     * @param \Pyz\Zed\ProductDetail\Persistence\ProductDetailRepositoryInterface $productDetailRepository
     * @param \Pyz\Zed\ProductDetail\Persistence\ProductDetailEntityManagerInterface $productDetailEntityManager
     */
    public function __construct(
        ProductDetailRepositoryInterface $productDetailRepository,
        ProductDetailEntityManagerInterface $productDetailEntityManager
    ) {
        $this->productDetailRepository = $productDetailRepository;
        $this->productDetailEntityManager = $productDetailEntityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function findProductAbstractBySku(string $sku): ?ProductResponseTransfer
    {
        return $this->productDetailRepository->findProductAbstractBySku($sku);
    }
}
