<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ProductStorage\Plugin;

use Generated\Shared\Transfer\AttributeMapStorageTransfer;
use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Client\Kernel\AbstractPlugin;
use Spryker\Client\ProductStorage\Dependency\Plugin\ProductViewExpanderPluginInterface;
use Spryker\Client\ProductStorage\ProductStorageConfig;

/**
 * @method \Spryker\Client\ProductStorage\ProductStorageFactory getFactory()
 * @method \Spryker\Client\ProductStorage\ProductStorageClientInterface getClient()
 */
class BundleProductsExpanderPlugin extends AbstractPlugin implements ProductViewExpanderPluginInterface
{
    protected const KEY_SKU = 'sku';

    /**
     * {@inheritDoc}
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
            $bundledProduct[ProductStorageConfig::RESOURCE_TYPE_ATTRIBUTE_MAP] = (new AttributeMapStorageTransfer())->toArray();
            if (!isset($bundledProduct[static::KEY_SKU])) {
                continue;
            }

            $bundledProductView = $this->getClient()->mapProductStorageData($bundledProduct, $localeName);
            $bundledProductView->setQuantity($quantity);
            $productViewTransfer->addBundledProduct($bundledProductView);
        }

        return $productViewTransfer;
    }
}
