<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Checkout\Process\Steps;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerShop\Yves\CheckoutPage\CheckoutPageConfig;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCartClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface;
use SprykerShop\Yves\CheckoutPage\Process\Steps\SuccessStep;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Checkout
 * @group Process
 * @group Steps
 * @group SuccessStepTest
 * Add your own group annotations below this line
 */
class SuccessStepTest extends Unit
{
    /**
     * @return void
     */
    public function testExecuteShouldEmptyQuoteTransfer()
    {
        $customerClientMock = $this->createCustomerClientMock();
        $customerClientMock->expects($this->once())->method('markCustomerAsDirty');

        $successStep = $this->createSuccessStep($customerClientMock);

        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->addItem(new ItemTransfer());

        $this->assertTrue($successStep->preCondition($quoteTransfer));
        $quoteTransfer = $successStep->execute($this->createRequest(), $quoteTransfer);

        $this->assertFalse($successStep->preCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testPostConditionsWhenOrderReferenceIsSetShouldReturnTrue()
    {
        $successStep = $this->createSuccessStep();

        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->setOrderReference('#12');

        $this->assertTrue($successStep->postCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testPostConditionsWhenOrderReferenceIsMissingShouldReturnFalse()
    {
        $successStep = $this->createSuccessStep();
        $quoteTransfer = new QuoteTransfer();

        $this->assertFalse($successStep->postCondition($quoteTransfer));
    }

    /**
     * @param \SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface|null $customerClientMock
     *
     * @return \SprykerShop\Yves\CheckoutPage\Process\Steps\SuccessStep
     */
    protected function createSuccessStep($customerClientMock = null)
    {
        if ($customerClientMock === null) {
            $customerClientMock = $this->createCustomerClientMock();
        }

        $cartClientMock = $this->createCartClientMock();
        $checkoutPageConfigMock = $this->createCheckoutPageConfigMock();

        return new SuccessStep(
            $customerClientMock,
            $cartClientMock,
            $checkoutPageConfigMock,
            'success_route',
            'escape_route'
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCartClientInterface
     */
    protected function createCartClientMock(): CheckoutPageToCartClientInterface
    {
        return $this->getMockBuilder(CheckoutPageToCartClientInterface::class)->getMock();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequest()
    {
        return Request::createFromGlobals();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface
     */
    protected function createCustomerClientMock(): CheckoutPageToCustomerClientInterface
    {
        return $this->getMockBuilder(CheckoutPageToCustomerClientInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\CheckoutPageConfig
     */
    protected function createCheckoutPageConfigMock(): CheckoutPageConfig
    {
        $checkoutPageConfigMock = $this->getMockBuilder(CheckoutPageConfig::class)->setMethods(['cleanCartAfterOrderCreation'])->getMock();
        $checkoutPageConfigMock->method('cleanCartAfterOrderCreation')->willReturn(true);

        return $checkoutPageConfigMock;
    }
}
