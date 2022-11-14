<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MessageBroker;

use Spryker\Zed\Asset\Communication\Plugin\MessageBroker\AssetAddedMessageHandlerPlugin;
use Spryker\Zed\Asset\Communication\Plugin\MessageBroker\AssetDeletedMessageHandlerPlugin;
use Spryker\Zed\Asset\Communication\Plugin\MessageBroker\AssetUpdatedMessageHandlerPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\CorrelationIdMessageAttributeProviderPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\TimestampMessageAttributeProviderPlugin;
use Spryker\Zed\MessageBroker\Communication\Plugin\MessageBroker\ValidationMiddlewarePlugin;
use Spryker\Zed\MessageBroker\MessageBrokerDependencyProvider as SprykerMessageBrokerDependencyProvider;
use Spryker\Zed\MessageBrokerAws\Communication\Plugin\MessageBroker\Receiver\AwsSqsMessageReceiverPlugin;
use Spryker\Zed\MessageBrokerAws\Communication\Plugin\MessageBroker\Sender\AwsSnsMessageSenderPlugin;
use Spryker\Zed\MessageBrokerAws\Communication\Plugin\MessageBroker\Sender\AwsSqsMessageSenderPlugin;
use Spryker\Zed\MessageBrokerAws\Communication\Plugin\MessageBroker\Sender\HttpMessageSenderPlugin;
use Spryker\Zed\OauthClient\Communication\Plugin\MessageBroker\AccessTokenMessageAttributeProviderPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentCancelReservationFailedMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentConfirmationFailedMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentConfirmedMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentMethodAddedMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentMethodDeletedMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentPreauthorizationFailedMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentPreauthorizedMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentRefundedMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentRefundFailedMessageHandlerPlugin;
use Spryker\Zed\Payment\Communication\Plugin\MessageBroker\PaymentReservationCanceledMessageHandlerPlugin;
use Spryker\Zed\Product\Communication\Plugin\MessageBroker\InitializeProductExportMessageHandlerPlugin;
use Spryker\Zed\Store\Communication\Plugin\MessageBroker\CurrentStoreReferenceMessageAttributeProviderPlugin;
use Spryker\Zed\Store\Communication\Plugin\MessageBroker\StoreReferenceMessageValidatorPlugin;

class MessageBrokerDependencyProvider extends SprykerMessageBrokerDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageSenderPluginInterface>
     */
    public function getMessageSenderPlugins(): array
    {
        return [
            new AwsSnsMessageSenderPlugin(),
            new AwsSqsMessageSenderPlugin(),
            new HttpMessageSenderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageReceiverPluginInterface>
     */
    public function getMessageReceiverPlugins(): array
    {
        return [
            new AwsSqsMessageReceiverPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageHandlerPluginInterface>
     */
    public function getMessageHandlerPlugins(): array
    {
        return [
            new PaymentCancelReservationFailedMessageHandlerPlugin(),
            new PaymentConfirmationFailedMessageHandlerPlugin(),
            new PaymentConfirmedMessageHandlerPlugin(),
            new PaymentPreauthorizationFailedMessageHandlerPlugin(),
            new PaymentPreauthorizedMessageHandlerPlugin(),
            new PaymentReservationCanceledMessageHandlerPlugin(),
            new PaymentRefundedMessageHandlerPlugin(),
            new PaymentRefundFailedMessageHandlerPlugin(),
            new PaymentMethodAddedMessageHandlerPlugin(),
            new PaymentMethodDeletedMessageHandlerPlugin(),
            new AssetAddedMessageHandlerPlugin(),
            new AssetUpdatedMessageHandlerPlugin(),
            new AssetDeletedMessageHandlerPlugin(),
            new InitializeProductExportMessageHandlerPlugin(),
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
            new CurrentStoreReferenceMessageAttributeProviderPlugin(),
            new AccessTokenMessageAttributeProviderPlugin(),
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

    /**
     * @return array<\Spryker\Zed\MessageBrokerExtension\Dependency\Plugin\MessageValidatorPluginInterface>
     */
    public function getExternalValidatorPlugins(): array
    {
        return [
            new StoreReferenceMessageValidatorPlugin(),
        ];
    }
}
