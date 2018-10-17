<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CheckoutPage;

use Spryker\Yves\Kernel\Container;
use Spryker\Yves\Kernel\Plugin\Pimple;
use Spryker\Yves\Payment\Plugin\PaymentFormFilterPlugin;
use SprykerShop\Yves\CartNoteWidget\Plugin\CheckoutPage\CartNoteQuoteItemNoteWidgetPlugin;
use SprykerShop\Yves\CartNoteWidget\Plugin\CheckoutPage\CartNoteQuoteNoteWidgetPlugin;
use SprykerShop\Yves\CheckoutPage\CheckoutPageDependencyProvider as SprykerShopCheckoutPageDependencyProvider;
use SprykerShop\Yves\CustomerPage\Form\CheckoutAddressCollectionForm;
use SprykerShop\Yves\CustomerPage\Form\CustomerCheckoutForm;
use SprykerShop\Yves\CustomerPage\Form\DataProvider\CheckoutAddressFormDataProvider;
use SprykerShop\Yves\CustomerPage\Form\GuestForm;
use SprykerShop\Yves\CustomerPage\Form\LoginForm;
use SprykerShop\Yves\CustomerPage\Form\RegisterForm;
use SprykerShop\Yves\DiscountWidget\Plugin\CheckoutPage\CheckoutVoucherFormWidgetPlugin;
use SprykerShop\Yves\SalesOrderThresholdWidget\Plugin\CheckoutPage\SalesOrderThresholdWidgetPlugin;

class CheckoutPageDependencyProvider extends SprykerShopCheckoutPageDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getSummaryPageWidgetPlugins(): array
    {
        return [
            CheckoutVoucherFormWidgetPlugin::class,
            CartNoteQuoteItemNoteWidgetPlugin::class, #CartNoteFeature
            CartNoteQuoteNoteWidgetPlugin::class, #CartNoteFeature
            SalesOrderThresholdWidgetPlugin::class,
        ];
    }

    /**
     * @return mixed[]
     */
    protected function getCustomerStepSubForms()
    {
        return [
            LoginForm::class,
            $this->getCustomerCheckoutForm(RegisterForm::class, RegisterForm::BLOCK_PREFIX),
            $this->getCustomerCheckoutForm(GuestForm::class, GuestForm::BLOCK_PREFIX),
        ];
    }

    /**
     * @return mixed[]
     */
    protected function getCustomerFormTypes()
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
     * @return \SprykerShop\Yves\CustomerPage\Form\CustomerCheckoutForm|\Symfony\Component\Form\FormInterface
     */
    protected function getCustomerCheckoutForm($subForm, $blockPrefix)
    {
        return $this->getFormFactory()->createNamed(
            $blockPrefix,
            CustomerCheckoutForm::class,
            null,
            [CustomerCheckoutForm::SUB_FORM_CUSTOMER => $subForm]
        );
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    private function getFormFactory()
    {
        return (new Pimple())->getApplication()['form.factory'];
    }

    /**
     * @return string[]
     */
    protected function getAddressStepSubForms()
    {
        return [
            CheckoutAddressCollectionForm::class,
        ];
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface|null
     */
    protected function getAddressStepFormDataProvider(Container $container)
    {
        return new CheckoutAddressFormDataProvider($this->getCustomerClient($container), $this->getStore());
    }

    /**
     * @return \Spryker\Yves\Checkout\Dependency\Plugin\Form\SubFormFilterPluginInterface[]
     */
    protected function getSubFormFilterPlugins(): array
    {
        return [
            new PaymentFormFilterPlugin(),
        ];
    }
}
