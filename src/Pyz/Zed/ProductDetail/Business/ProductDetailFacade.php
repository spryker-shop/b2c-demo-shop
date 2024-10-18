<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetail\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\ProductDetail\Business\ProductDetailBusinessFactory getFactory()
 * @method \Pyz\Zed\ProductDetail\Persistence\ProductDetailRepositoryInterface getRepository()
 */
class ProductDetailFacade extends AbstractFacade implements ProductDetailFacadeInterface
{
    /**
     * {@inheritdoc}
     */
    public function findProductAbstractBySku(string $sku): ?ProductResponseTransfer
    {
        return $this->getRepository()->findProductAbstractBySku($sku);
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     * @api
     */
    /*public function saveProduct(ProductAbstractTransfer $productTransfer): ProductAbstractTransfer
    {
        $productManager = $this->getFactory()->createProductDetailManager();

        return $productManager->saveProduct($productTransfer); // Ensure this method exists in ProductManager
    }*/
}
