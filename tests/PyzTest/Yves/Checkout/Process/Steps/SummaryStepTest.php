<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Checkout\Process\Steps;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use SprykerShop\Yves\CheckoutPage\CheckoutPageConfig;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCheckoutClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToProductBundleClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Service\CheckoutPageToShipmentServiceBridge;
use SprykerShop\Yves\CheckoutPage\Dependency\Service\CheckoutPageToShipmentServiceInterface;
use SprykerShop\Yves\CheckoutPage\Process\Steps\SummaryStep;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Checkout
 * @group Process
 * @group Steps
 * @group SummaryStepTest
 * Add your own group annotations below this line
 */
class SummaryStepTest extends Unit
{
    /**
     * @var \PyzTest\Yves\Checkout\CheckoutBusinessTester
     */
    public $tester;

    /**
     * @return void
     */
    public function testPostConditionShouldReturnWhenQuoteReadyForSummaryDisplay()
    {
        $summaryStep = $this->createSummaryStep();

        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->setBillingAddress(new AddressTransfer());

        $paymentTransfer = new PaymentTransfer();
        $paymentTransfer->setPaymentProvider('test');

        $quoteTransfer->setPayment($paymentTransfer);
        $quoteTransfer->setShipment(new ShipmentTransfer());

        $this->assertTrue($summaryStep->postCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testRequireInputShouldBeTrue()
    {
        $summaryStep = $this->createSummaryStep();

        $this->assertTrue($summaryStep->requireInput(new QuoteTransfer()));
    }

    /**
     * @return \SprykerShop\Yves\CheckoutPage\Process\Steps\SummaryStep
     */
    protected function createSummaryStep()
    {
        $productBundleClient = $this->createProductBundleClient();

        return new SummaryStep(
            $productBundleClient,
            $this->createShipmentServiceMock(),
            $this->createConfigMock(),
            'shipment',
            'escape_route',
            $this->getCheckoutClientMock()
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToProductBundleClientInterface
     */
    protected function createProductBundleClient(): CheckoutPageToProductBundleClientInterface
    {
        return $this->getMockBuilder(CheckoutPageToProductBundleClientInterface::class)->getMock();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequest()
    {
        return Request::createFromGlobals();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Service\CheckoutPageToShipmentServiceInterface
     */
    protected function createShipmentServiceMock(): CheckoutPageToShipmentServiceInterface
    {
        return $this->getMockBuilder(CheckoutPageToShipmentServiceBridge::class)
            ->setConstructorArgs([$this->tester->getShipmentService()])
            ->enableProxyingToOriginalMethods()
            ->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\CheckoutPageConfig
     */
    protected function createConfigMock(): CheckoutPageConfig
    {
        return $this->getMockBuilder(CheckoutPageConfig::class)->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCheckoutClientInterface
     */
    public function getCheckoutClientMock(): CheckoutPageToCheckoutClientInterface
    {
        return $this->getMockBuilder(CheckoutPageToCheckoutClientInterface::class)->getMock();
    }
}
