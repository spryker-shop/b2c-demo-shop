<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Checkout\Process\Steps;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\AddressBuilder;
use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\DataBuilder\ShipmentBuilder;
use Generated\Shared\Transfer\AddressesTransfer;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerShop\Yves\CheckoutPage\CheckoutPageConfig;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCalculationClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface;
use SprykerShop\Yves\CheckoutPage\Dependency\Service\CheckoutPageToCustomerServiceBridge;
use SprykerShop\Yves\CheckoutPage\Dependency\Service\CheckoutPageToCustomerServiceInterface;
use SprykerShop\Yves\CheckoutPage\Process\Steps\AddressStep;
use SprykerShop\Yves\CheckoutPage\Process\Steps\AddressStep\AddressStepExecutor;
use SprykerShop\Yves\CheckoutPage\Process\Steps\AddressStep\PostConditionChecker;
use SprykerShop\Yves\CheckoutPage\Process\Steps\PostConditionCheckerInterface;
use SprykerShop\Yves\CheckoutPage\Process\Steps\StepExecutorInterface;
use SprykerShop\Yves\CheckoutPageExtension\Dependency\Plugin\AddressTransferExpanderPluginInterface;
use SprykerShop\Yves\CustomerPage\Plugin\CheckoutPage\CustomerAddressExpanderPlugin;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Checkout
 * @group Process
 * @group Steps
 * @group AddressStepTest
 * Add your own group annotations below this line
 */
class AddressStepTest extends Unit
{
    /**
     * @var \PyzTest\Yves\Checkout\CheckoutBusinessTester
     */
    public $tester;

    /**
     * @return void
     */
    public function testExecuteAddressStepWhenGuestIsSubmittedShouldUseDataFromAddressFromForm()
    {
        $customerClientMock = $this->createCustomerClientMock();
        $addressStep = $this->createAddressStep($customerClientMock);

        $quoteTransfer = new QuoteTransfer();
        $addressTransfer = new AddressTransfer();
        $addressTransfer->setAddress1('add1');
        $quoteTransfer->setShippingAddress($addressTransfer);
        $quoteTransfer->setBillingAddress(clone $addressTransfer);

        $addressStep->execute($this->createRequest(), $quoteTransfer);

        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getShippingAddress()->getAddress1());
        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getBillingAddress()->getAddress1());
    }

    /**
     * @return void
     */
    public function testExecuteAddressStepWhenGuestIsSubmittedShouldUseDataFromAddressFromFormWithItemLevelShippingAddresses()
    {
        $addressStep = $this->createAddressStep();

        $addressTransfer = (new AddressBuilder([AddressTransfer::ADDRESS1 => 'add1']))->build();

        $quoteTransfer = (new QuoteBuilder())
            ->withItem((new ItemBuilder())->withShipment())
            ->build();

        $quoteTransfer->getItems()[0]->getShipment()->setShippingAddress($addressTransfer);
        $quoteTransfer->setBillingAddress(clone $addressTransfer);

        $addressStep->execute($this->createRequest(), $quoteTransfer);

        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress()->getAddress1());
        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getBillingAddress()->getAddress1());
    }

    /**
     * @return void
     */
    public function testExecuteAddressStepWhenLoggedInUserCreatesNewAddress()
    {
        $addressTransfer = new AddressTransfer();
        $addressTransfer->setIdCustomerAddress(1);
        $addressTransfer->setAddress1('add1');

        $customerTransfer = new CustomerTransfer();
        $customerTransfer->addBillingAddress($addressTransfer);
        $shipmentAddress = clone $addressTransfer;
        $shipmentAddress->setIdCustomerAddress(2);

        $addressesTransfer = new AddressesTransfer();
        $addressesTransfer->addAddress($addressTransfer);
        $addressesTransfer->addAddress($shipmentAddress);
        $customerTransfer->setAddresses($addressesTransfer);

        $customerClientMock = $this->createCustomerClientMock();
        $customerClientMock->expects($this->once())->method('getCustomer')->willReturn($customerTransfer);

        $addressStep = $this->createAddressStep($customerClientMock);

        $quoteTransfer = new QuoteTransfer();

        $billingAddressTransfer = new AddressTransfer();
        $billingAddressTransfer->setIdCustomerAddress(1);
        $quoteTransfer->setBillingAddress($billingAddressTransfer);

        $shippingAddressTransfer = new AddressTransfer();
        $shippingAddressTransfer->setIdCustomerAddress(1);
        $quoteTransfer->setShippingAddress($shippingAddressTransfer);

        $addressStep->execute($this->createRequest(), $quoteTransfer);

        $this->assertEquals($shipmentAddress->getAddress1(), $quoteTransfer->getShippingAddress()->getAddress1());
        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getBillingAddress()->getAddress1());
    }

    /**
     * @return void
     */
    public function testExecuteAddressStepWhenLoggedInUserCreatesNewAddressWithItemLevelShippingAddresses()
    {
        $addressTransfer = new AddressTransfer();
        $addressTransfer->setIdCustomerAddress(1);
        $addressTransfer->setAddress1('add1');

        $customerTransfer = new CustomerTransfer();
        $customerTransfer->addBillingAddress($addressTransfer);
        $shippingAddress = clone $addressTransfer;
        $shippingAddress->setIdCustomerAddress(2);

        $addressesTransfer = new AddressesTransfer();
        $addressesTransfer->addAddress($addressTransfer);
        $addressesTransfer->addAddress($shippingAddress);
        $customerTransfer->setAddresses($addressesTransfer);

        $customerClientMock = $this->createCustomerClientMock();
        $customerClientMock->expects($this->once())->method('getCustomer')->willReturn($customerTransfer);

        $addressStep = $this->createAddressStep($customerClientMock);
        $shipmentBuilder = (new ShipmentBuilder())
            ->withShippingAddress(new AddressBuilder([AddressTransfer::ID_CUSTOMER_ADDRESS => 1]));
        $itemBuilder = (new ItemBuilder())
            ->withShipment($shipmentBuilder);
        $addressBuilder = new AddressBuilder([AddressTransfer::ID_CUSTOMER_ADDRESS => 1]);
        $quoteTransfer = (new QuoteBuilder())
            ->withBillingAddress($addressBuilder)
            ->withItem($itemBuilder)
            ->build();

        $addressStep->execute($this->createRequest(), $quoteTransfer);

        $this->assertEquals($shippingAddress->getAddress1(), $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress()->getAddress1());
        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getBillingAddress()->getAddress1());
    }

    /**
     * @return void
     */
    public function testExecuteWhenBillingAddressSameAsShippingSelectedShouldCopyShipmentIntoBilling()
    {
        $addressTransfer = new AddressTransfer();
        $addressTransfer->setIdCustomerAddress(1);
        $addressTransfer->setAddress1('add1');

        $customerTransfer = new CustomerTransfer();
        $addressesTransfer = new AddressesTransfer();
        $addressesTransfer->addAddress($addressTransfer);
        $customerTransfer->setAddresses($addressesTransfer);

        $customerClientMock = $this->createCustomerClientMock();
        $customerClientMock->expects($this->once())->method('getCustomer')->willReturn($customerTransfer);

        $addressStep = $this->createAddressStep($customerClientMock);

        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->setBillingSameAsShipping(true);

        $shippingAddressTransfer = new AddressTransfer();
        $shippingAddressTransfer->setIdCustomerAddress(1);
        $quoteTransfer->setShippingAddress($shippingAddressTransfer);

        $addressStep->execute($this->createRequest(), $quoteTransfer);

        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getShippingAddress()->getAddress1());
        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getBillingAddress()->getAddress1());
    }

    /**
     * @return void
     */
    public function testExecuteWhenBillingAddressSameAsShippingSelectedShouldCopyShipmentIntoBillingWithItemLevelShippingAddresses()
    {
        $addressTransfer = (new AddressBuilder([
            AddressTransfer::ID_CUSTOMER_ADDRESS => 1,
            AddressTransfer::ADDRESS1 => 'add1',
        ]))->build();

        $customerTransfer = new CustomerTransfer();
        $addressesTransfer = new AddressesTransfer();
        $addressesTransfer->addAddress($addressTransfer);
        $customerTransfer->setAddresses($addressesTransfer);

        $customerClientMock = $this->createCustomerClientMock();
        $customerClientMock->expects($this->once())->method('getCustomer')->willReturn($customerTransfer);

        $addressStep = $this->createAddressStep($customerClientMock);

        $addressBuilder = new AddressBuilder([AddressTransfer::ID_CUSTOMER_ADDRESS => 1]);
        $shipmentBuilder = (new ShipmentBuilder())
            ->withShippingAddress($addressBuilder);
        $itemBuilder = (new ItemBuilder())
            ->withShipment($shipmentBuilder);
        $quoteTransfer = (new QuoteBuilder([QuoteTransfer::BILLING_SAME_AS_SHIPPING => true]))
            ->withItem($itemBuilder)
            ->build();

        $addressStep->execute($this->createRequest(), $quoteTransfer);

        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getItems()[0]->getShipment()->getShippingAddress()->getAddress1());
        $this->assertEquals($addressTransfer->getAddress1(), $quoteTransfer->getBillingAddress()->getAddress1());
    }

    /**
     * @return void
     */
    public function testPostConditionWhenNoAddressesSetShouldReturnFalse()
    {
        $addressStep = $this->createAddressStep();
        $this->assertFalse($addressStep->postCondition(new QuoteTransfer()));
    }

    /**
     * @return void
     */
    public function testPostConditionIfShippingIsEmptyShouldReturnFalse()
    {
        $addressStep = $this->createAddressStep();
        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->setBillingAddress(new AddressTransfer());

        $this->assertFalse($addressStep->postCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testPostConditionIfBillingIsEmptyShouldReturnFalse()
    {
        $addressStep = $this->createAddressStep();
        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->setShippingAddress(new AddressTransfer());

        $this->assertFalse($addressStep->postCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testPostConditionIfBillingIsEmptyShouldReturnFalseWithItemLevelShippingAddresses()
    {
        $addressStep = $this->createAddressStep();

        $shipmentBuilder = (new ShipmentBuilder())
            ->withShippingAddress();
        $itemBuilder = (new ItemBuilder())
            ->withShipment($shipmentBuilder);
        $quoteTransfer = (new QuoteBuilder())
            ->withItem($itemBuilder)
            ->build();

        $this->assertFalse($addressStep->postCondition($quoteTransfer));
    }

    /**
     * @return void
     */
    public function testPostConditionIfEmptyAddressesIsSetShouldReturnFalse()
    {
        // Arrange
        $addressStep = $this->createAddressStep();
        $quoteTransfer = new QuoteTransfer();
        $quoteTransfer->setShippingAddress(new AddressTransfer());
        $quoteTransfer->setBillingAddress(new AddressTransfer());

        // Act
        $result = $addressStep->postCondition($quoteTransfer);

        // Assert
        $this->assertFalse($result);
    }

    /**
     * @return void
     */
    public function testPostConditionIfNotEmptyAddressesIsSetShouldReturnTrue()
    {
        // Arrange
        $addressStep = $this->createAddressStep();

        $quoteTransfer = (new QuoteBuilder())
            ->withShippingAddress()
            ->withAnotherBillingAddress()
            ->build();

        // Act
        $result = $addressStep->postCondition($quoteTransfer);

        // Assert
        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testPostConditionIfAddressesIsSetShouldReturnTrueWithItemLevelShippingAddresses()
    {
        // Arrange
        $addressStep = $this->createAddressStep();

        $shipmentBuilder = (new ShipmentBuilder())
            ->withShippingAddress();
        $itemBuilder = (new ItemBuilder())
            ->withShipment($shipmentBuilder);
        $quoteTransfer = (new QuoteBuilder())
            ->withBillingAddress()
            ->withItem($itemBuilder)
            ->build();

        // Act
        $result = $addressStep->postCondition($quoteTransfer);

        // Assert
        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testRequireInputShouldReturnTrue()
    {
        $addressStep = $this->createAddressStep();
        $this->assertTrue($addressStep->requireInput(new QuoteTransfer()));
    }

    /**
     * @param \SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface|\PHPUnit\Framework\MockObject\MockObject|null $customerClientMock
     *
     * @return \SprykerShop\Yves\CheckoutPage\Process\Steps\AddressStep|\PHPUnit\Framework\MockObject\MockObject
     */
    protected function createAddressStep($customerClientMock = null): AddressStep
    {
        if ($customerClientMock === null) {
            $customerClientMock = $this->createCustomerClientMock();
        }

        $addressStepMock = $this->getMockBuilder(AddressStep::class)
            ->setMethods(['getDataClass'])
            ->setConstructorArgs([
                $this->createCalculationClientMock(),
                $this->createAddressStepExecutorMock($customerClientMock),
                $this->createAddressStepPostConditionCheckerMock(),
                $this->createConfigMock(),
                'address_step',
                'escape_route',
                $this->getCheckoutAddressStepEnterPreCheckPlugins(),
            ])
            ->getMock();

        $addressStepMock->method('getDataClass')->willReturn(new QuoteTransfer());

        return $addressStepMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCalculationClientInterface
     */
    protected function createCalculationClientMock(): CheckoutPageToCalculationClientInterface
    {
        $calculationMock = $this->getMockBuilder(CheckoutPageToCalculationClientInterface::class)->getMock();

        return $calculationMock;
    }

    /**
     * @param \SprykerShop\Yves\CheckoutPage\Dependency\Client\CheckoutPageToCustomerClientInterface|\PHPUnit\Framework\MockObject\MockObject|null $customerClientMock
     *
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Process\Steps\StepExecutorInterface
     */
    protected function createAddressStepExecutorMock($customerClientMock): StepExecutorInterface
    {
        return $this->getMockBuilder(AddressStepExecutor::class)
            ->setConstructorArgs([
                $this->createCustomerServiceMock(),
                $customerClientMock,
                $this->getShoppingListItemExpanderPlugins(),
            ])
            ->enableProxyingToOriginalMethods()
            ->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Process\Steps\PostConditionCheckerInterface
     */
    protected function createAddressStepPostConditionCheckerMock(): PostConditionCheckerInterface
    {
        return $this->getMockBuilder(PostConditionChecker::class)
            ->setConstructorArgs([$this->createCustomerServiceMock()])
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
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPage\Dependency\Service\CheckoutPageToCustomerServiceInterface
     */
    protected function createCustomerServiceMock(): CheckoutPageToCustomerServiceInterface
    {
        return $this->getMockBuilder(CheckoutPageToCustomerServiceBridge::class)
            ->setConstructorArgs([$this->tester->getCustomerService()])
            ->enableProxyingToOriginalMethods()
            ->getMock();
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerShop\Yves\CheckoutPageExtension\Dependency\Plugin\AddressTransferExpanderPluginInterface
     */
    protected function createCustomerAddressExpanderPluginMock(): AddressTransferExpanderPluginInterface
    {
        return $this->getMockBuilder(CustomerAddressExpanderPlugin::class)
            ->enableProxyingToOriginalMethods()
            ->getMock();
    }

    /**
     * @return \SprykerShop\Yves\CheckoutPageExtension\Dependency\Plugin\AddressTransferExpanderPluginInterface[]
     */
    public function getShoppingListItemExpanderPlugins(): array
    {
        return [
            $this->createCustomerAddressExpanderPluginMock(),
        ];
    }

    /**
     * @return \SprykerShop\Yves\CheckoutPageExtension\Dependency\Plugin\CheckoutAddressStepEnterPreCheckPluginInterface[]
     */
    public function getCheckoutAddressStepEnterPreCheckPlugins(): array
    {
        return [];
    }
}
