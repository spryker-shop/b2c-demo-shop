<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
            $product['prices'] =array_key_exists('prices' , $product) ?: [];
            $currentProductPriceTransfer = $priceProductClient->resolveProductPrice($product['prices']);
            $product['price'] = $currentProductPriceTransfer->getPrice();
            $product['prices'] = $currentProductPriceTransfer->getPrices();
        }

        return $result;
    }
}
