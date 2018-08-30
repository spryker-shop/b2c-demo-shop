<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerShop\Yves\CartPage\Plugin;

use ArrayObject;
use Spryker\Yves\Kernel\AbstractPlugin;
use SprykerShop\Yves\CartPage\Dependency\Plugin\CartVariantAttributeMapperPluginInterface;

/**
 * @method \SprykerShop\Yves\CartPage\CartPageFactory getFactory()
 */
class CartVariantAttributeMapperPlugin extends AbstractPlugin implements CartVariantAttributeMapperPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\ItemTransfer[]|\ArrayObject $items
     * @param string $localeName
     *
     * @return array
     */
    public function buildMap(ArrayObject $items, $localeName)
    {
        return $this->getFactory()->createCartItemsAttributeMapper()->buildMap($items, $localeName);
    }
}
