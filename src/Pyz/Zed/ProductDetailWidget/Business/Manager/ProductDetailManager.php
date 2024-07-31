<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailPageWidget\Business\Manager;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailEntityManagerInterface;
use Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailRepositoryInterface;

class ProductDetailManager implements ProductDetailManagerInterface
{
    /**
     * @var \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailRepositoryInterface
     */
    protected $productDetailRepository;

    /**
     * @var \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailEntityManagerInterface
     */
    protected $productDetailEntityManager;

    /**
     * @param \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailRepositoryInterface $productDetailRepository
     * @param \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailEntityManagerInterface $productDetailEntityManager
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
