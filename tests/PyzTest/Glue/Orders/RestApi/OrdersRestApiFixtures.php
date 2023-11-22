<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Orders\RestApi;

use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use PyzTest\Glue\Orders\OrdersApiTester;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Orders
 * @group RestApi
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class OrdersRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'test username';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    /**
     * @var int
     */
    protected const TEST_GRAND_TOTAL = 1;

    /**
     * @var \Generated\Shared\Transfer\SaveOrderTransfer
     */
    protected SaveOrderTransfer $saveOrderTransfer;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerWithoutOrders;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerWithOrders;

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerWithoutOrders(): CustomerTransfer
    {
        return $this->customerWithoutOrders;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerWithOrders(): CustomerTransfer
    {
        return $this->customerWithOrders;
    }

    /**
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    public function geSaveOrderTransfer(): SaveOrderTransfer
    {
        return $this->saveOrderTransfer;
    }

    /**
     * @param \PyzTest\Glue\Orders\OrdersApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(OrdersApiTester $I): FixturesContainerInterface
    {
        $this->customerWithoutOrders = $this->createCustomerTransfer($I, static::TEST_USERNAME, static::TEST_PASSWORD);

        $this->saveOrderTransfer = $this->createOrderTransfer($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\Orders\OrdersApiTester $I
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function createProductTransfer(OrdersApiTester $I): ProductConcreteTransfer
    {
        return $I->haveProduct();
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param array $productTransfers
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function createQuoteTransfer(CustomerTransfer $customerTransfer, array $productTransfers): AbstractTransfer
    {
        return (new QuoteBuilder())
            ->withItem($productTransfers)
            ->withCustomer([CustomerTransfer::CUSTOMER_REFERENCE => $customerTransfer->getCustomerReference()])
            ->withTotals([TotalsTransfer::GRAND_TOTAL => static::TEST_GRAND_TOTAL])
            ->withShippingAddress()
            ->withBillingAddress()
            ->withCurrency()
            ->withPayment()
            ->build();
    }

    /**
     * @param \PyzTest\Glue\Orders\OrdersApiTester $I
     *
     * @return \Generated\Shared\Transfer\SaveOrderTransfer
     */
    protected function createOrderTransfer(OrdersApiTester $I): SaveOrderTransfer
    {
        $this->customerWithOrders = $this->createCustomerTransfer($I, static::TEST_USERNAME, static::TEST_PASSWORD);
        $quote = $this->createQuoteTransfer($this->customerWithOrders, [$this->createProductTransfer($I)]);

        return $I->haveOrderFromQuote($quote, $this->createStateMachine($I));
    }

    /**
     * @param \PyzTest\Glue\Orders\OrdersApiTester $I
     *
     * @return string
     */
    protected function createStateMachine(OrdersApiTester $I): string
    {
        $testStateMachineProcessName = 'DummyPayment01';
        $I->configureTestStateMachine([$testStateMachineProcessName]);

        return $testStateMachineProcessName;
    }

    /**
     * @param \PyzTest\Glue\Orders\OrdersApiTester $I
     * @param string $name
     * @param string $password
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function createCustomerTransfer(OrdersApiTester $I, string $name, string $password): CustomerTransfer
    {
        $customerTransfer = $I->haveCustomer([
            CustomerTransfer::USERNAME => $name,
            CustomerTransfer::PASSWORD => $password,
            CustomerTransfer::NEW_PASSWORD => $password,
        ]);

        return $I->confirmCustomer($customerTransfer);
    }
}
