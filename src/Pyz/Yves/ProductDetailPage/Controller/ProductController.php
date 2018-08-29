<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductDetailPage\Controller;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerShop\Yves\ProductDetailPage\Controller\ProductController as SprykerShopProductController;
use Symfony\Component\HttpFoundation\Request;

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
        foreach ($productViewTransfer->getBundledProductIds() as $productId => $quantity) {
            $bundledProduct = $this->getFactory()->getProductStoragePyzClient()->findProductConcreteStorageData($productId, $this->getLocale());
            $bundledProduct['idProductAbstract'] = $bundledProduct['id_product_abstract'];
            $bundledProduct['productUrl'] = $bundledProduct['url'];
            $bundledProduct['quantity'] = $quantity;
            $bundledProductView = $this->getFactory()->getProductStoragePyzClient()->mapProductStorageData(['attributeMap' => [], 'idProductConcrete' => $bundledProduct['id_product_concrete']], $this->getLocale());
            $image = $bundledProductView->getImages()->offsetGet(0);
            if ($image) {
                $bundledProduct['image'] = $image->getExternalUrlSmall();
            }
            $bundledProducts[] = $bundledProduct;
        }

        $r = 3;
        return [
            'cart' => $quoteTransfer,
            'product' => $productViewTransfer,
            'productUrl' => $this->getProductUrl($productViewTransfer),
            'bundledProducts' => $bundledProducts,
        ];
    }
}
