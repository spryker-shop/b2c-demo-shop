<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductStorage\Plugin;

use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\ProductStorage\Dependency\Plugin\ProductViewExpanderPluginInterface;

/**
 * @method \Spryker\Client\ProductStorage\ProductStorageFactory getFactory()
 * @method \Spryker\Client\ProductStorage\ProductStorageClientInterface getClient()
 */
class BundleProductsExpanderPlugin extends AbstractPlugin implements ProductViewExpanderPluginInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     * @param array $productData
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ProductViewTransfer
     */
    public function expandProductViewTransfer(ProductViewTransfer $productViewTransfer, array $productData, $localeName)
    {
        foreach ($productViewTransfer->getBundledProductIds() as $productId => $quantity) {
            $bundledProduct = $this->getClient()->findProductConcreteStorageData($productId, $localeName);
            $bundledProduct['idProductAbstract'] = $bundledProduct['id_product_abstract'];
            $bundledProduct['productUrl'] = $bundledProduct['url'];
            $bundledProduct['quantity'] = $quantity;
            $bundledProductView = $this->getClient()->mapProductStorageData(
                [
                    'attributeMap' => [],
                    'idProductConcrete' => $bundledProduct['id_product_concrete'],
                    'idProductAbstract' => $bundledProduct['id_product_abstract'],
                    'sku' => $bundledProduct['sku'],
                ],
                $localeName
            );
            $image = $bundledProductView->getImages()->offsetGet(0);
            if ($image) {
                $bundledProduct['image'] = $image->getExternalUrlSmall();
            }
            $productViewTransfer->addBundledProduct($bundledProduct);
        }

        return $productViewTransfer;
    }
}
