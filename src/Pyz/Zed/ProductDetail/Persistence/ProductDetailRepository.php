<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Pyz\Zed\ProductDetail\Persistence;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductResponseTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\ProductDetail\Persistence\ProductDetailPersistenceFactory getFactory()
 */
class ProductDetailRepository extends AbstractRepository implements ProductDetailRepositoryInterface
{
    /**
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductResponseTransfer
     */
    public function findProductAbstractBySku(string $sku): ProductResponseTransfer
    {
        /** @var \Orm\Zed\Product\Persistence\SpyProductAbstract|null $productEntity */
        $productEntity = $this->getFactory()->createProductAbstractQuery()
//            ->filterBySku($sku)  ToDo: uncomment and debug
            ->findOne();

        $productResponseTransfer = new ProductResponseTransfer();

        if ($productEntity) {
            $productAbstractTransfer = $this->getFactory()->createProductAbstractMapper()
                ->mapEntityToProductAbstractTransfer($productEntity, new ProductAbstractTransfer());

            $productResponseTransfer->setProductAbstract($productAbstractTransfer);
            $productResponseTransfer->setIsSuccess(true);
        } else {
            $productResponseTransfer->setIsSuccess(false);
            $productResponseTransfer->setMessage('Product not found');
        }

        return $productResponseTransfer;
    }
}
