<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Checkout\Process\Steps;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface;
use SprykerShop\Yves\CheckoutPage\Process\Steps\CustomerStep;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Checkout
 * @group Process
 * @group Steps
 * @group CustomerStepTest
 * Add your own group annotations below this line
 */
class CustomerStepTest extends Unit
{
    /**
     * @return void
     */
    public function testExecuteShouldTriggerAuthHandler(): void
    {
        $authHandlerMock = $this->createAuthHandlerMock();
        $authHandlerMock->expects($this->once())->method('addToDataClass')->willReturnArgument(1);

        $customerStep = $this->createCustomerStep(null, $authHandlerMock);
        $customerStep->execute($this->createRequest(), new QuoteTransfer());
    }

    /**
     * @return void
     */
    public function testPostConditionWhenCustomerTransferNotSetShouldReturnFalse(): void
    {
        $customerStep = $this->createCustomerStep();
        $this->assertFalse($customerStep->postCondition(new QuoteTransfer()));
    }

    /**
     * @return void
     */
    public function testPostConditionWhenCustomerIsLoggedInAndTriesToLoginAsAGuestShouldReturnFalse(): void
    {
        $customerClientMock = $this->createCustomerClientMock();
        $customerClientMock->expects($this->once())->method('getCustomer')->willReturn(new CustomerTransfer());

        $customerStep = $this->createCustomerStep($customerClientMock);
        $quoteTransfer = new QuoteTransfer();
        $customerTransfer = new CustomerTransfer();
        $customerTransfer->setIsGuest(true);
        $quoteTransfer->setCustomer($customerTransfer);

        $this->assertFalse($customerStep->postCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testPostConditionWhenInvalidCustomerSetShouldReturnFalse(): void
    {
        $customerStep = $this->createCustomerStep();
        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->setCustomer(new CustomerTransfer());

        $this->assertFalse($customerStep->postCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testPostConditionWhenGuestCustomerSetShouldReturnTrue(): void
    {
        $customerStep = $this->createCustomerStep();
        $quoteTransfer = new QuoteTransfer();
        $customerTransfer = new CustomerTransfer();
        $customerTransfer->setIsGuest(true);
        $quoteTransfer->setCustomer($customerTransfer);

        $this->assertTrue($customerStep->postCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testRequireInputWhenCustomerIsSetShouldReturnTrue(): void
    {
        $customerStep = $this->createCustomerStep();
        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->setCustomer(new CustomerTransfer());

        $this->assertTrue($customerStep->requireInput($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testRequireInputWhenCustomerLoggedInShouldReturnFalse(): void
    {
        $customerClientMock = $this->createCustomerClientMock();
        $customerClientMock->expects($this->once())->method('getCustomer')->willReturn(new CustomerTransfer());

        $customerStep = $this->createCustomerStep($customerClientMock);
        $quoteTransfer = new QuoteTransfer();

        $this->assertFalse($customerStep->requireInput($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testRequireInputWhenNotLoggedInAndNotYetSetInQuoteShouldReturnTrue(): void
    {
        $customerStep = $this->createCustomerStep();
        $this->assertTrue($customerStep->requireInput(new QuoteTransfer()));
    }

    /**
     * @param \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface|null $customerClientMock
     * @param \PHPUnit\Framework\MockObject\MockObject|\Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface|null $authHandlerMock
     *
     * @return \SprykerShop\Yves\CheckoutPage\Process\Steps\CustomerStep
     */
    protected function createCustomerStep($customerClientMock = null, $authHandlerMock = null): CustomerStep
    {
        if ($customerClientMock === null) {
            $customerClientMock = $this->createCustomerClientMock();
        }
        if ($authHandlerMock === null) {
            $authHandlerMock = $this->createAuthHandlerMock();
        }

        return new CustomerStep(
            $customerClientMock,
            $authHandlerMock,
            'customer_step',
            'escape_route',
            '/logout',
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface
     */
    protected function createAuthHandlerMock(): StepHandlerPluginInterface
    {
        return $this->getMockBuilder(StepHandlerPluginInterface::class)->getMock();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequest(): Request
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
}
