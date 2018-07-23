<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\GiftCard;

use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardCurrencyMatchDecisionRulePlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardIsActiveDecisionRulePlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardIsUsedDecisionRulePlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardRecreateValueProviderPlugin;
use Spryker\Zed\GiftCard\GiftCardDependencyProvider as SprykerGiftCardDependencyProvider;
use Spryker\Zed\GiftCardBalance\Communication\Plugin\BalanceCheckerApplicabilityPlugin;
use Spryker\Zed\GiftCardBalance\Communication\Plugin\BalanceTransactionLogPaymentSaverPlugin;

class GiftCardDependencyProvider extends SprykerGiftCardDependencyProvider
{
    /**
     * @return \Spryker\Zed\GiftCard\Dependency\Plugin\GiftCardDecisionRulePluginInterface[]
     */
    protected function getDecisionRulePlugins()
    {
        return [
            new GiftCardIsActiveDecisionRulePlugin(),
            new GiftCardCurrencyMatchDecisionRulePlugin(),
            new GiftCardIsUsedDecisionRulePlugin(),
            new BalanceCheckerApplicabilityPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\GiftCard\Dependency\Plugin\GiftCardPaymentSaverPluginInterface[]
     */
    protected function getPaymentSaverPlugins()
    {
        return [
            new BalanceTransactionLogPaymentSaverPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\GiftCard\Dependency\Plugin\GiftCardValueProviderPluginInterface
     */
    protected function getValueProviderPlugin()
    {
        return new GiftCardRecreateValueProviderPlugin();
    }
}
