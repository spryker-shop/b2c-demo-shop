<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\GiftCard;

use Spryker\Zed\GiftCard\Dependency\Plugin\GiftCardValueProviderPluginInterface;
use Spryker\Zed\GiftCard\GiftCardDependencyProvider as SprykerGiftCardDependencyProvider;
use Spryker\Zed\GiftCardBalance\Communication\Plugin\BalanceCheckerApplicabilityPlugin;
use Spryker\Zed\GiftCardBalance\Communication\Plugin\BalanceTransactionLogPaymentSaverPlugin;
use Spryker\Zed\GiftCardBalance\Communication\Plugin\GiftCardBalanceValueProviderPlugin;

class GiftCardDependencyProvider extends SprykerGiftCardDependencyProvider
{
    /**
     * @return \Spryker\Zed\GiftCard\Dependency\Plugin\GiftCardValueProviderPluginInterface
     */
    protected function getValueProviderPlugin(): GiftCardValueProviderPluginInterface
    {
        return new GiftCardBalanceValueProviderPlugin();
    }

    /**
     * @return array<\Spryker\Zed\GiftCard\Dependency\Plugin\GiftCardPaymentSaverPluginInterface>
     */
    protected function getPaymentSaverPlugins(): array
    {
        return [
            new BalanceTransactionLogPaymentSaverPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\GiftCard\Dependency\Plugin\GiftCardDecisionRulePluginInterface>
     */
    protected function getDecisionRulePlugins(): array
    {
        return array_merge(parent::getDecisionRulePlugins(), [
            new BalanceCheckerApplicabilityPlugin(),
        ]);
    }
}
