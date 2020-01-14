<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Checkout\Process\Steps;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\PaymentMethodsBuilder;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\Messenger\FlashMessenger\FlashMessengerInterface;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection;
use Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCalculationClientBridge;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCalculationClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToPaymentClientInterface;
use SprykerShop\Yves\CheckoutPage\Process\Steps\PaymentStep;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Checkout
 * @group Process
 * @group Steps
 * @group PaymentStepTest
 * Add your own group annotations below this line
 */
class PaymentStepTest extends Unit
{
    /**
     * @var \PyzTest\Yves\Checkout\CheckoutBusinessTester:
     */
    protected $tester;

    /**
     * @dataProvider executeDataProvider
     *
     * @param \SprykerShop\Yves\CheckoutPage\Process\Steps\PaymentStep $paymentStep
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    public function testExecuteShouldSelectPlugin(PaymentStep $paymentStep, QuoteTransfer $quoteTransfer): void
    {
        $paymentStep->execute($this->createRequest(), $quoteTransfer);
    }

    /**
     * @dataProvider postConditionsDataProvider
     *
     * @param \SprykerShop\Yves\CheckoutPage\Process\Steps\PaymentStep $paymentStep
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    public function testPostConditionsShouldReturnTrueWhenPaymentSet(
        PaymentStep $paymentStep,
        QuoteTransfer $quoteTransfer
    ): void {
        // Act
        $postConditionFulfilled = $paymentStep->postCondition($quoteTransfer);

        // Assert
        $this->assertTrue($postConditionFulfilled);
    }

    /**
     * @dataProvider shipmentDataProvider
     *
     * @param \SprykerShop\Yves\CheckoutPage\Process\Steps\PaymentStep $paymentStep
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    public function testShipmentRequireInputShouldReturnTrue(
        PaymentStep $paymentStep,
        QuoteTransfer $quoteTransfer
    ): void {
        // Act
        $isInputRequired = $paymentStep->requireInput($quoteTransfer);

        // Assert
        $this->assertTrue($isInputRequired);
    }

    /**
     * @return array
     */
    public function executeDataProvider(): array
    {
        return [
            'payment step executes without an error' => $this->addDataForExecuteDataProvider(),
        ];
    }

    /**
     * @return array
     */
    protected function addDataForExecuteDataProvider(): array
    {
        $paymentPluginMock = $this->createPaymentPluginMock();
        $paymentPluginMock->expects($this->once())->method('addToDataClass');

        $stepHandlerPluginCollection = new StepHandlerPluginCollection();
        $stepHandlerPluginCollection->add($paymentPluginMock, 'test');

        $paymentStep = $this->createPaymentStep($stepHandlerPluginCollection);

        $quoteTransfer = (new QuoteBuilder())
            ->withPayment([
                'paymentSelection' => 'test',
            ])
            ->build();

        return [$paymentStep, $quoteTransfer];
    }

    /**
     * @return array
     */
    public function postConditionsDataProvider(): array
    {
        return [
            'post condition is fulfilled' => $this->addDataForPostConditionsDataProvider(),
        ];
    }

    /**
     * @return array
     */
    protected function addDataForPostConditionsDataProvider(): array
    {
        $paymentStep = $this->createPaymentStep(new StepHandlerPluginCollection());
        $quoteTransfer = (new QuoteBuilder())
            ->withPayment([
                'paymentProvider' => 'test',
                'paymentSelection' => 'test',
            ])
            ->build();
        $quoteTransfer->setPayment($quoteTransfer->getPayments()[0]);

        return [$paymentStep, $quoteTransfer];
    }

    /**
     * @return array
     */
    public function shipmentDataProvider(): array
    {
        return [
            'shipment required input is not provided' => $this->addDataForShipmentDataProvider(),
        ];
    }

    /**
     * @return array
     */
    protected function addDataForShipmentDataProvider(): array
    {
        $paymentStep = $this->createPaymentStep(new StepHandlerPluginCollection());
        $quoteTransfer = (new QuoteBuilder())
            ->build();

        return [$paymentStep, $quoteTransfer];
    }

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginCollection $paymentPlugins
     *
     * @return \SprykerShop\Yves\CheckoutPage\Process\Steps\PaymentStep
     */
    protected function createPaymentStep(StepHandlerPluginCollection $paymentPlugins): PaymentStep
    {
        return new PaymentStep(
            $this->getPaymentClientMock(),
            $paymentPlugins,
            'payment',
            'escape_route',
            $this->getFlashMessengerMock(),
            $this->getCalculationClientMock(),
            $this->getCheckoutPaymentStepEnterPreCheckPlugins()
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToPaymentClientInterface
     */
    public function getPaymentClientMock(): CheckoutPageToPaymentClientInterface
    {
        $paymentClientMock = $this->getMockBuilder(CheckoutPageToPaymentClientInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getAvailableMethods'])
            ->getMock();

        $paymentMethodsTransfer = (new PaymentMethodsBuilder())
            ->withMethod([
                'methodName' => 'test',
            ])
            ->build();

        $paymentClientMock
            ->method('getAvailableMethods')
            ->willReturn($paymentMethodsTransfer);

        return $paymentClientMock;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequest()
    {
        return Request::createFromGlobals();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Yves\StepEngine\Dependency\Plugin\Handler\StepHandlerPluginInterface
     */
    protected function createPaymentPluginMock(): StepHandlerPluginInterface
    {
        return $this->getMockBuilder(StepHandlerPluginInterface::class)->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCalculationClientInterface
     */
    protected function getCalculationClientMock(): CheckoutPageToCalculationClientInterface
    {
        return $this->getMockBuilder(CheckoutPageToCalculationClientBridge::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Yves\Messenger\FlashMessenger\FlashMessengerInterface
     */
    protected function getFlashMessengerMock(): FlashMessengerInterface
    {
        return $this->getMockBuilder(FlashMessengerInterface::class)->getMock();
    }

    /**
     * @return \SprykerShop\Yves\CheckoutPageExtension\Dependency\Plugin\CheckoutPaymentStepEnterPreCheckPluginInterface[]
     */
    public function getCheckoutPaymentStepEnterPreCheckPlugins(): array
    {
        return [];
    }
}
