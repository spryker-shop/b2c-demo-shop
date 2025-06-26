<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Quote;

use Spryker\Zed\Currency\Communication\Plugin\Quote\DefaultCurrencyQuoteExpandBeforeCreatePlugin;
use Spryker\Zed\Currency\Communication\Plugin\Quote\QuoteCurrencyValidatorPlugin;
use Spryker\Zed\OrderCustomReference\Communication\Plugin\Quote\OrderCustomReferenceQuoteFieldsAllowedForSavingProviderPlugin;
use Spryker\Zed\Price\Communication\Plugin\Quote\QuotePriceModeValidatorPlugin;
use Spryker\Zed\Quote\QuoteDependencyProvider as SprykerQuoteDependencyProvider;
use Spryker\Zed\Store\Communication\Plugin\Quote\QuoteStoreValidatorPlugin;

class QuoteDependencyProvider extends SprykerQuoteDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteValidatorPluginInterface>
     */
    protected function getQuoteValidatorPlugins(): array
    {
        return [
            new QuoteCurrencyValidatorPlugin(),
            new QuotePriceModeValidatorPlugin(),
            new QuoteStoreValidatorPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteExpandBeforeCreatePluginInterface>
     */
    protected function getQuoteExpandBeforeCreatePlugins(): array
    {
        return [
            new DefaultCurrencyQuoteExpandBeforeCreatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteFieldsAllowedForSavingProviderPluginInterface>
     */
    protected function getQuoteFieldsAllowedForSavingProviderPlugins(): array
    {
        return [
            new OrderCustomReferenceQuoteFieldsAllowedForSavingProviderPlugin(),
        ];
    }
}
