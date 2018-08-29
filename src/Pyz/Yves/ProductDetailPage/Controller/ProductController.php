<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ProductDetailPage\Controller;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Symfony\Component\HttpFoundation\Request;
use SprykerShop\Yves\ProductDetailPage\Controller\ProductController as SprykerShopProductController;

/**
 * @method \Spryker\Client\Product\ProductClientInterface getClient()
 * @method \Pyz\Yves\ProductDetailPage\ProductDetailPageFactory getFactory()
 */
class ProductController extends SprykerShopProductController
{
    /**
     * @param array $productData
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executeDetailAction(array $productData, Request $request): array
    {
        $productViewTransfer = $this->getFactory()
            ->getProductStorageClient()
            ->mapProductStorageData($productData, $this->getLocale(), $this->getSelectedAttributes($request));

        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->addItem(
            (new ItemTransfer())->setIdProductAbstract($productViewTransfer->getIdProductAbstract())
        );

        $bundledProducts = [];
        foreach ($productData['bundled_product_ids'] as $bundledProductId) {
            $bundledProduct = $this->getFactory()->getProductStoragePyzClient()->findProductConcreteStorageData($bundledProductId, $this->getLocale());

            $bundledProducts[] = $bundledProduct;
        }


        return [
            'cart' => $quoteTransfer,
            'product' => $productViewTransfer,
            'productUrl' => $this->getProductUrl($productViewTransfer),
            'bundledProducts' => $bundledProducts,
        ];
    }
}
