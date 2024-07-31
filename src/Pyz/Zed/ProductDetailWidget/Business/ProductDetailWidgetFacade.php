<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductDetailPageWidget\Business;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\ProductDetailPageWidget\Business\ProductDetailWidgetBusinessFactory getFactory()
 * @method \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailRepositoryInterface getRepository()
 */
class ProductDetailWidgetFacade extends AbstractFacade implements ProductDetailWidgetFacadeInterface
{
    /**
     * {@inheritdoc}
     */
    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer
    {
        return $this->getRepository()->findProductAbstractById($idProductAbstract);
    }

    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     * @api
     */
    public function saveProduct(ProductAbstractTransfer $productTransfer): ProductAbstractTransfer
    {
        $productManager = $this->getFactory()->createProductDetailManager();

        return $productManager->saveProduct($productTransfer); // Ensure this method exists in ProductManager
    }
}
