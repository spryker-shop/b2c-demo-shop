<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CheckoutRestApi;

use Spryker\Zed\CheckoutRestApi\CheckoutRestApiConfig as SprykerCheckoutRestApiConfig;

class CheckoutRestApiConfig extends SprykerCheckoutRestApiConfig
{
    /**
     * @return bool
     */
    public function shouldExecuteQuotePostRecalculationPlugins(): bool
    {
        return false;
    }

    /**
     * Specification:
     * - If set to `true`, quote recalculation in a stack of {@link \Spryker\Zed\CheckoutRestApiExtension\Dependency\Plugin\QuoteMapperPluginInterface} will be enabled.
     * - Impacts {@link \Spryker\Zed\CheckoutRestApi\Business\CheckoutRestApiFacade::getCheckoutData()} method.
     * - Impacts {@link \Spryker\Zed\CheckoutRestApi\Business\CheckoutRestApiFacade::placeOrder()} method.
     *
     * @api
     *
     * @return bool
     */
    public function isRecalculationEnabledForQuoteMapperPlugins(): bool
    {
        return false;
    }
}
