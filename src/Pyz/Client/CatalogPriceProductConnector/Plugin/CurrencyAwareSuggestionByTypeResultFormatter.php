<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\CatalogPriceProductConnector\Plugin;

use Spryker\Client\CatalogPriceProductConnector\Plugin\CurrencyAwareSuggestionByTypeResultFormatter as SprykerCurrencyAwareSuggestionByTypeResultFormatter;

/**
 * @method \Spryker\Client\CatalogPriceProductConnector\CatalogPriceProductConnectorFactory getFactory()
 */
class CurrencyAwareSuggestionByTypeResultFormatter extends SprykerCurrencyAwareSuggestionByTypeResultFormatter
{
    /**
     * Fallback method to work with PriceProduct module without price dimensions support.
     *
     * @param array $result
     *
     * @return mixed|array
     */
    protected function formatSearchResultWithoutPriceDimensions(array $result)
    {
        $priceProductClient = $this->getFactory()->getPriceProductClient();
        foreach ($result as &$product) {
            $product['prices'] = array_key_exists('prices', $product) ?: [];
            $currentProductPriceTransfer = $priceProductClient->resolveProductPrice($product['prices']);
            $product['price'] = $currentProductPriceTransfer->getPrice();
            $product['prices'] = $currentProductPriceTransfer->getPrices();
        }

        return $result;
    }
}
