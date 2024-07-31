<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailPageWidget\Persistence;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailPersistenceFactory getFactory()
 */
class ProductDetailRepository extends AbstractRepository implements ProductDetailRepositoryInterface
{
    /**
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer
    {
        /** @var \Orm\Zed\Product\Persistence\SpyProductAbstract $productEntity */
        $productEntity = $this->getFactory()->createProductAbstractQuery()
            ->filterByIdProductAbstract($idProductAbstract)
            ->findOne();

        if (!$productEntity) {
            return null;
        }

        return $this->getFactory()->createProductAbstractMapper()->mapEntityToProductAbstractTransfer($productEntity, new ProductAbstractTransfer());
    }
}
