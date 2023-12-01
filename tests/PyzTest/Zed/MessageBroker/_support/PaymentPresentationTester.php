<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker;

use Codeception\Actor;
use Codeception\Scenario;
use Generated\Shared\Transfer\CurrencyTransfer;
use Orm\Zed\Oms\Persistence\SpyOmsOrderItemState;
use Orm\Zed\Oms\Persistence\SpyOmsOrderItemStateQuery;
use Orm\Zed\Oms\Persistence\SpyOmsOrderProcess;
use Orm\Zed\Oms\Persistence\SpyOmsOrderProcessQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery;
use PyzTest\Zed\MessageBroker\PageObject\SalesPage;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(\PyzTest\Zed\Payment\PHPMD)
 */
class PaymentPresentationTester extends Actor
{
    use _generated\PaymentPresentationTesterActions;

    /**
     * @var string
     */
    protected const CURRENCY_USD = 'USD';

    /**
     * @var string
     */
    protected const DEFAULT_OMS_PROCESS_NAME = 'ForeignPaymentStateMachine01';

    /**
     * @param \Codeception\Scenario $scenario
     */
    public function __construct(Scenario $scenario)
    {
        parent::__construct($scenario);

        $this->amZed();
        $this->amLoggedInUser();
    }

    /**
     * @param string $initialItemState
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    public function haveSalesOrder(string $initialItemState): SpySalesOrder
    {
        $this->haveCurrency([CurrencyTransfer::CODE => static::CURRENCY_USD]);

        return $this->haveSalesOrderEntity(
            [],
            [
                'email' => 'test@test.com',
                'currency_iso_code' => static::CURRENCY_USD,
            ],
            $initialItemState,
            static::DEFAULT_OMS_PROCESS_NAME,
        );
    }

    /**
     * @param string $paymentMessageTransferClassName
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrderEntity
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function havePaymentMessageTransfer(
        string $paymentMessageTransferClassName,
        SpySalesOrder $salesOrderEntity,
    ): TransferInterface {
        return (new $paymentMessageTransferClassName())->setOrderItemIds(
            $this->getSalesOrderItemIds($salesOrderEntity),
        );
    }

    /**
     * @param \Spryker\Shared\Kernel\Transfer\TransferInterface $paymentMessageTransfer
     *
     * @return void
     */
    public function handlePaymentMessageTransfer(TransferInterface $paymentMessageTransfer): void
    {
        $channelName = 'payment-commands';
        $this->setupMessageBroker($paymentMessageTransfer::class, $channelName);
        $messageBrokerFacade = $this->getLocator()->messageBroker()->facade();
        $messageBrokerFacade->sendMessage($paymentMessageTransfer);
        $messageBrokerFacade->startWorker(
            $this->buildMessageBrokerWorkerConfigTransfer([$channelName], 1),
        );
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrder
     * @param string $finalState
     *
     * @return void
     */
    public function assertOrderHasCorrectState(SpySalesOrder $salesOrder, string $finalState): void
    {
        $omsProcess = $this->getOmsProcess();
        $this->assertNotNull($omsProcess, 'oms process doesnt exist');

        $finalOrderItemState = $this->getOrderItemState($finalState);
        $this->assertNotNull($finalOrderItemState, 'order item state doesnt exist');

        $this->amOnPage(
            sprintf(
                SalesPage::SALES_ORDER_ITEM_PAGE_URL,
                $omsProcess->getIdOmsOrderProcess(),
                $finalOrderItemState->getIdOmsOrderItemState(),
            ),
        );
        $this->wait(10);

        $this->canSee($salesOrder->getOrderReference());
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $salesOrder
     *
     * @return list<int>
     */
    protected function getSalesOrderItemIds(SpySalesOrder $salesOrder): array
    {
        $spySalesOrderItemQuery = new SpySalesOrderItemQuery();
        $spySalesOrderItemQuery->filterByOrder($salesOrder);
        $fetchedOrderItemIds = $spySalesOrderItemQuery->find();

        $orderItemIds = [];
        foreach ($fetchedOrderItemIds as $fetchedOrderItemId) {
            $orderItemIds[] = $fetchedOrderItemId->getIdSalesOrderItem();
        }

        return $orderItemIds;
    }

    /**
     * @param string $stateName
     *
     * @return \Orm\Zed\Oms\Persistence\SpyOmsOrderItemState|null
     */
    protected function getOrderItemState(string $stateName): ?SpyOmsOrderItemState
    {
        $omsOrderItemStateQuery = new SpyOmsOrderItemStateQuery();
        $omsOrderItemStateQuery->filterByName($stateName);

        return $omsOrderItemStateQuery->findOne();
    }

    /**
     * @return \Orm\Zed\Oms\Persistence\SpyOmsOrderProcess|null
     */
    protected function getOmsProcess(): ?SpyOmsOrderProcess
    {
        $omsOrderProcessQuery = new SpyOmsOrderProcessQuery();
        $omsOrderProcessQuery->filterByName(static::DEFAULT_OMS_PROCESS_NAME);

        return $omsOrderProcessQuery->findOne();
    }
}
