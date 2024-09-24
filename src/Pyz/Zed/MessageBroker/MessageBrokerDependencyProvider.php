<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MessageBroker;

use Spryker\Zed\Asset\Communication\Plugin\MessageBroker\AssetMessageHandlerPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\CorrelationIdMessageAttributeProviderPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\TenantActorMessageAttributeProviderPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\TimestampMessageAttributeProviderPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\TransactionIdMessageAttributeProviderPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\ValidationMiddlewarePlugin;
use Spryker\Zed\MessageBroker\MessageBrokerDependencyProvider as SprykerMessageBrokerDependencyProvider;
use Spryker\Zed\MessageBrokerAws\Communication\Plugin\MessageBroker\Receiver\HttpChannelMessageReceiverPlugin;
use Spryker\Zed\MessageBrokerAws\Communication\Plugin\MessageBroker\Sender\HttpChannelMessageSenderPlugin;
use Spryker\Zed\OauthClient\Communication\Plugin\MessageBroker\AccessTokenMessageAttributeProviderPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentMethodMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentOperationsMessageHandlerPlugin;
use Spryker\Zed\Product\Communication\Plugin\MessageBroker\ProductExportMessageHandlerPlugin;
use Spryker\Zed\ProductReview\Communication\Plugin\MessageBroker\ProductReviewAddReviewsMessageHandlerPlugin;
use Spryker\Zed\SalesPaymentDetail\Communication\Plugin\MessageBroker\PaymentCreatedMessageHandlerPlugin;
use Spryker\Zed\SearchHttp\Communication\Plugin\MessageBroker\SearchEndpointMessageHandlerPlugin;
use Spryker\Zed\Session\Communication\Plugin\MessageBroker\SessionTrackingIdMessageAttributeProviderPlugin;
use Spryker\Zed\TaxApp\Communication\Plugin\MessageBroker\TaxAppMessageHandlerPlugin;

class MessageBrokerDependencyProvider extends SprykerMessageBrokerDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageSenderPluginInterface>
     */
    public function getMessageSenderPlugins(): array
    {
        return [
            new HttpChannelMessageSenderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageReceiverPluginInterface>
     */
    public function getMessageReceiverPlugins(): array
    {
        return [
            new HttpChannelMessageReceiverPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageHandlerPluginInterface>
     */
    public function getMessageHandlerPlugins(): array
    {
        return [
            new PaymentMethodMessageHandlerPlugin(),
            new AssetMessageHandlerPlugin(),
            new ProductExportMessageHandlerPlugin(),
            new SearchEndpointMessageHandlerPlugin(),
            new ProductReviewAddReviewsMessageHandlerPlugin(),
            new TaxAppMessageHandlerPlugin(),
            new PaymentOperationsMessageHandlerPlugin(),
            new PaymentCreatedMessageHandlerPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageAttributeProviderPluginInterface>
     */
    public function getMessageAttributeProviderPlugins(): array
    {
        return [
            new CorrelationIdMessageAttributeProviderPlugin(),
            new TimestampMessageAttributeProviderPlugin(),
            new AccessTokenMessageAttributeProviderPlugin(),
            new TransactionIdMessageAttributeProviderPlugin(),
            new SessionTrackingIdMessageAttributeProviderPlugin(),
            new TenantActorMessageAttributeProviderPlugin(),
        ];
    }

    /**
     * @return array<\Symfony\Component\Messenger\Middleware\MiddlewareInterface>
     */
    public function getMiddlewarePlugins(): array
    {
        return [
            new ValidationMiddlewarePlugin(),
        ];
    }
}
