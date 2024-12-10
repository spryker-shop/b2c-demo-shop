<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetail\Persistence;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Pyz\Zed\ProductDetail\Persistence\ProductDetailEntityManagerInterface;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\ProductDetail\Persistence\ProductDetailPersistenceFactory getFactory()
 */
class ProductDetailEntityManager extends AbstractEntityManager implements ProductDetailEntityManagerInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function saveProductAbstract(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        $spyProductAbstract = $this->getFactory()
            ->createProductAbstractQuery()
            ->filterBySku($productAbstractTransfer->getSku())
            ->findOneOrCreate();

        $spyProductAbstract = $this->getFactory()
            ->createProductAbstractMapper()
            ->mapProductAbstractTransferToEntity($productAbstractTransfer, $spyProductAbstract);

        $spyProductAbstract->save();

        $productAbstractTransfer->fromArray($spyProductAbstract->toArray(), true);

        return $productAbstractTransfer;
    }

    /**
     * Finds a product by its ID.
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductById(int $idProductAbstract): ?ProductAbstractTransfer
    {
        $spyProductAbstract = $this->getFactory()
            ->createProductAbstractQuery()
            ->filterByIdProductAbstract($idProductAbstract)
            ->findOne();

        if ($spyProductAbstract === null) {
            return null;
        }

        $productAbstractTransfer = new ProductAbstractTransfer();
        $productAbstractTransfer->fromArray($spyProductAbstract->toArray(), true);

        return $productAbstractTransfer;
    }
}
