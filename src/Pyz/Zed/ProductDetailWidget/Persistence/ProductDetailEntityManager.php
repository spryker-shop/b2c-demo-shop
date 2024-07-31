<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailPageWidget\Persistence;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailPersistenceFactory getFactory()
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
            ->filterByIdProductAbstract($productAbstractTransfer->getIdProductAbstract())
            ->findOneOrCreate();

        $spyProductAbstract = $this->getFactory()
            ->createProductAbstractMapper()
            ->mapProductAbstractTransferToEntity($productAbstractTransfer, $spyProductAbstract);

        $spyProductAbstract->save();

        $productAbstractTransfer->fromArray($spyProductAbstract->toArray(), true);

        return $productAbstractTransfer;
    }
}
