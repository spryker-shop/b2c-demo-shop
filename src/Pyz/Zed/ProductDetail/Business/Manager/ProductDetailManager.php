<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailWidget\Business\Manager;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailEntityManagerInterface;
use Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailRepositoryInterface;

class ProductDetailManager implements ProductDetailManagerInterface
{
    /**
     * @var \Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailRepositoryInterface
     */
    protected $productDetailRepository;

    /**
     * @var \Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailEntityManagerInterface
     */
    protected $productDetailEntityManager;

    /**
     * @param \Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailRepositoryInterface $productDetailRepository
     * @param \Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailEntityManagerInterface $productDetailEntityManager
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
    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer
    {
        return $this->productDetailRepository->findProductAbstractById($idProductAbstract);
    }
}
