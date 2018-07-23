<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Payment;

use Spryker\Shared\Nopayment\NopaymentConfig;
use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardOrderSaverPlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardPaymentMethodFilterPlugin;
use Spryker\Zed\GiftCard\Communication\Plugin\GiftCardPreCheckPlugin;
use Spryker\Zed\GiftCard\GiftCardConfig;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Nopayment\Communication\Plugin\Checkout\NopaymentPreCheckPlugin;
use Spryker\Zed\Nopayment\Communication\Plugin\Payment\PriceToPayPaymentMethodFilterPlugin;
use Spryker\Zed\Payment\Dependency\Plugin\Checkout\CheckoutPluginCollectionInterface;
use Spryker\Zed\Payment\PaymentDependencyProvider as SprykerPaymentDependencyProvider;

class PaymentDependencyProvider extends SprykerPaymentDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->extendPaymentPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function extendPaymentPlugins(Container $container)
    {
        $container->extend(
            PaymentDependencyProvider::CHECKOUT_PLUGINS,
            function (CheckoutPluginCollectionInterface $pluginCollection) {
                $pluginCollection->add(
                    new GiftCardOrderSaverPlugin(),
                    GiftCardConfig::PROVIDER_NAME,
                    PaymentDependencyProvider::CHECKOUT_ORDER_SAVER_PLUGINS
                );

                $pluginCollection->add(
                    new GiftCardPreCheckPlugin(),
                    GiftCardConfig::PROVIDER_NAME,
                    PaymentDependencyProvider::CHECKOUT_PRE_CHECK_PLUGINS
                );

                $pluginCollection->add(
                    new NopaymentPreCheckPlugin(),
                    NopaymentConfig::PAYMENT_PROVIDER_NAME,
                    PaymentDependencyProvider::CHECKOUT_ORDER_SAVER_PLUGINS
                );

                return $pluginCollection;
            }
        );

        return $container;
    }

    /**
     * @return \Spryker\Zed\Payment\Dependency\Plugin\Payment\PaymentMethodFilterPluginInterface[]
     */
    protected function getPaymentMethodFilterPlugins()
    {
        return [
            new PriceToPayPaymentMethodFilterPlugin(),
            new GiftCardPaymentMethodFilterPlugin(),
        ];
    }
}
