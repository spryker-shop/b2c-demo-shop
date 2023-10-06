<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Mail;

use Spryker\Zed\AvailabilityNotification\Communication\Plugin\Mail\AvailabilityNotificationMailTypeBuilderPlugin;
use Spryker\Zed\AvailabilityNotification\Communication\Plugin\Mail\AvailabilityNotificationSubscriptionMailTypeBuilderPlugin;
use Spryker\Zed\AvailabilityNotification\Communication\Plugin\Mail\AvailabilityNotificationUnsubscribedMailTypeBuilderPlugin;
use Spryker\Zed\Customer\Communication\Plugin\Mail\CustomerRegistrationConfirmationMailTypeBuilderPlugin;
use Spryker\Zed\Customer\Communication\Plugin\Mail\CustomerRegistrationMailTypeBuilderPlugin;
use Spryker\Zed\Customer\Communication\Plugin\Mail\CustomerRestoredPasswordConfirmationMailTypeBuilderPlugin;
use Spryker\Zed\Customer\Communication\Plugin\Mail\CustomerRestorePasswordMailTypeBuilderPlugin;
use Spryker\Zed\GiftCardMailConnector\Communication\Plugin\Mail\GiftCardDeliveryMailTypeBuilderPlugin;
use Spryker\Zed\GiftCardMailConnector\Communication\Plugin\Mail\GiftCardUsageMailTypeBuilderPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Mail\Business\Model\Provider\MailProviderCollectionAddInterface;
use Spryker\Zed\Mail\MailConfig;
use Spryker\Zed\Mail\MailDependencyProvider as SprykerMailDependencyProvider;
use Spryker\Zed\Newsletter\Communication\Plugin\Mail\NewsletterSubscribedMailTypeBuilderPlugin;
use Spryker\Zed\Newsletter\Communication\Plugin\Mail\NewsletterUnsubscribedMailTypeBuilderPlugin;
use Spryker\Zed\Oms\Communication\Plugin\Mail\OrderConfirmationMailTypeBuilderPlugin;
use Spryker\Zed\Oms\Communication\Plugin\Mail\OrderShippedMailTypeBuilderPlugin;
use Spryker\Zed\SalesInvoice\Communication\Plugin\Mail\OrderInvoiceMailTypeBuilderPlugin;
use Spryker\Zed\SymfonyMailer\Communication\Plugin\Mail\SymfonyMailerProviderPlugin;
use Spryker\Zed\UserPasswordResetMail\Communication\Plugin\Mail\UserPasswordResetMailTypeBuilderPlugin;

class MailDependencyProvider extends SprykerMailDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->extendMailProviderCollection($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function extendMailProviderCollection(Container $container): Container
    {
        $container->extend(self::MAIL_PROVIDER_COLLECTION, function (MailProviderCollectionAddInterface $mailProviderCollection) {
            $mailProviderCollection
                ->addProvider(new SymfonyMailerProviderPlugin(), [
                    MailConfig::MAIL_TYPE_ALL,
                ]);

            return $mailProviderCollection;
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface>
     */
    protected function getMailTypeBuilderPlugins(): array
    {
        return [
            new CustomerRegistrationMailTypeBuilderPlugin(),
            new CustomerRegistrationConfirmationMailTypeBuilderPlugin(),
            new CustomerRestorePasswordMailTypeBuilderPlugin(),
            new CustomerRestoredPasswordConfirmationMailTypeBuilderPlugin(),
            new NewsletterSubscribedMailTypeBuilderPlugin(),
            new NewsletterUnsubscribedMailTypeBuilderPlugin(),
            new OrderConfirmationMailTypeBuilderPlugin(),
            new OrderShippedMailTypeBuilderPlugin(),
            new AvailabilityNotificationUnsubscribedMailTypeBuilderPlugin(),
            new AvailabilityNotificationSubscriptionMailTypeBuilderPlugin(),
            new AvailabilityNotificationMailTypeBuilderPlugin(),
            new UserPasswordResetMailTypeBuilderPlugin(),
            new GiftCardDeliveryMailTypeBuilderPlugin(),
            new GiftCardUsageMailTypeBuilderPlugin(),
            new OrderInvoiceMailTypeBuilderPlugin(),
        ];
    }
}
