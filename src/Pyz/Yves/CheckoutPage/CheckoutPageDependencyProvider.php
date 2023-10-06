<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CheckoutPage;

use Generated\Shared\Transfer\PaymentTransfer;
use Spryker\Shared\Kernel\Container\GlobalContainer;
use Spryker\Shared\Nopayment\NopaymentConfig;
use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Nopayment\Plugin\NopaymentHandlerPlugin;
use Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface;
use SprykerShop\Yves\CheckoutPage\CheckoutPageDependencyProvider as SprykerShopCheckoutPageDependencyProvider;
use SprykerShop\Yves\CheckoutPage\Plugin\StepEngine\PaymentForeignHandlerPlugin;
use SprykerShop\Yves\CustomerPage\Form\CheckoutAddressCollectionForm;
use SprykerShop\Yves\CustomerPage\Form\CustomerCheckoutForm;
use SprykerShop\Yves\CustomerPage\Form\GuestForm;
use SprykerShop\Yves\CustomerPage\Form\LoginForm;
use SprykerShop\Yves\CustomerPage\Form\RegisterForm;
use SprykerShop\Yves\CustomerPage\Plugin\CheckoutPage\CheckoutAddressFormDataProviderPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\CheckoutPage\CustomerAddressExpanderPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\CustomerStepHandler;
use SprykerShop\Yves\PaymentPage\Plugin\PaymentPage\PaymentForeignPaymentCollectionExtenderPlugin;
use SprykerShop\Yves\SalesOrderThresholdWidget\Plugin\CheckoutPage\SalesOrderThresholdWidgetPlugin;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

class CheckoutPageDependencyProvider extends SprykerShopCheckoutPageDependencyProvider
{
    /**
     * @uses \Spryker\Yves\Form\Plugin\Application\FormApplicationPlugin::SERVICE_FORM_FACTORY
     *
     * @var string
     */
    protected const SERVICE_FORM_FACTORY = 'form.factory';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->extendPaymentMethodHandler($container);

        return $container;
    }

    /**
     * @return array<string>
     */
    protected function getSummaryPageWidgetPlugins(): array
    {
        return [
            SalesOrderThresholdWidgetPlugin::class, #SalesOrderThresholdFeature
        ];
    }

    /**
     * @phpstan-return array<int, class-string<\Symfony\Component\Form\FormTypeInterface>|\Symfony\Component\Form\FormInterface>
     *
     * @return array<\Symfony\Component\Form\FormTypeInterface>|array<string>
     */
    protected function getCustomerStepSubForms(): array
    {
        return [
            LoginForm::class,
            $this->getCustomerCheckoutForm(RegisterForm::class, RegisterForm::BLOCK_PREFIX),
            $this->getCustomerCheckoutForm(GuestForm::class, GuestForm::BLOCK_PREFIX),
        ];
    }

    /**
     * @param string $subForm
     * @param string $blockPrefix
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getCustomerCheckoutForm($subForm, $blockPrefix): FormInterface
    {
        return $this->getFormFactory()->createNamed(
            $blockPrefix,
            CustomerCheckoutForm::class,
            null,
            [CustomerCheckoutForm::SUB_FORM_CUSTOMER => $subForm],
        );
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    protected function getFormFactory(): FormFactory
    {
        return (new GlobalContainer())->get(static::SERVICE_FORM_FACTORY);
    }

    /**
     * @return array<string>
     */
    protected function getAddressStepSubForms(): array
    {
        return [
            CheckoutAddressCollectionForm::class,
        ];
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function extendPaymentMethodHandler(Container $container): Container
    {
        $container->extend(static::PAYMENT_METHOD_HANDLER, function (StepHandlerPluginCollection $paymentMethodHandler) {
            $paymentMethodHandler->add(new NopaymentHandlerPlugin(), NopaymentConfig::PAYMENT_PROVIDER_NAME);
            $paymentMethodHandler->add(new PaymentForeignHandlerPlugin(), PaymentTransfer::FOREIGN_PAYMENTS);

            return $paymentMethodHandler;
        });

        return $container;
    }

    /**
     * @return array<\SprykerShop\Yves\CheckoutPageExtension\Dependency\Plugin\AddressTransferExpanderPluginInterface>
     */
    protected function getAddressStepExecutorAddressExpanderPlugins(): array
    {
        return [
            new CustomerAddressExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    protected function getCheckoutAddressFormDataProviderPlugin(): StepEngineFormDataProviderInterface
    {
        return new CheckoutAddressFormDataProviderPlugin();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface
     */
    protected function getCustomerStepHandler(): StepHandlerPluginInterface
    {
        return new CustomerStepHandler();
    }

    /**
     * @return array<\SprykerShop\Yves\CheckoutPageExtension\Dependency\Plugin\PaymentCollectionExtenderPluginInterface>
     */
    protected function getPaymentCollectionExtenderPlugins(): array
    {
        return [
            new PaymentForeignPaymentCollectionExtenderPlugin(),
        ];
    }
}
