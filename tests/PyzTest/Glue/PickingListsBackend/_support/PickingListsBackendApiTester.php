<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\PickingListsBackend;

use ArrayObject;
use Codeception\Util\HttpCode;
use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\DataBuilder\PickingListBuilder;
use Generated\Shared\DataBuilder\PickingListItemBuilder;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderFilterTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PickingListCollectionRequestTransfer;
use Generated\Shared\Transfer\PickingListItemTransfer;
use Generated\Shared\Transfer\PickingListTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Orm\Zed\PickingList\Persistence\SpyPickingListQuery;
use Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery;
use Spryker\Glue\PickingListsBackendApi\PickingListsBackendApiConfig;
use SprykerTest\Glue\Testify\Tester\BackendApiEndToEndTester;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(\PyzTest\Glue\PickingListsBackend\PHPMD)
 */
class PickingListsBackendApiTester extends BackendApiEndToEndTester
{
    use _generated\PickingListsBackendApiTesterActions;

    /**
     * @var string
     */
    protected const DEFAULT_OMS_PROCESS_NAME = 'DummyPayment01';

    /**
     * @var string
     */
    protected const DEFAULT_OMS_PROCESS_XML_LOCATION = 'config/Zed/oms';

    /**
     * @uses \Spryker\Glue\GlueJsonApiConvention\Request\RequestRelationshipBuilder::QUERY_INCLUDE
     *
     * @var string
     */
    protected const QUERY_INCLUDE = 'include';

    /**
     * @uses \Spryker\Glue\PickingListsBackendApi\PickingListsBackendApiConfig::RESPONSE_CODE_ENTITY_NOT_FOUND
     *
     * @var string
     */
    protected const RESPONSE_CODE_ENTITY_NOT_FOUND = '5303';

    /**
     * @var string
     */
    protected const ERROR_DETAIL_PICKING_LIST_NOT_FOUND = 'The picking list entity was not found.';

    /**
     * @param \Generated\Shared\Transfer\StockTransfer $warehouseTransfer
     * @param list<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteTransfers
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function createOrder(
        StockTransfer $warehouseTransfer,
        array $productConcreteTransfers,
    ): OrderTransfer {
        $this->configureTestStateMachine([static::DEFAULT_OMS_PROCESS_NAME], static::DEFAULT_OMS_PROCESS_XML_LOCATION);

        $quoteTransfer = $this->createQuoteTransfer($warehouseTransfer, $productConcreteTransfers);
        $saveOrderTransfer = $this->haveOrderFromQuote(
            $quoteTransfer,
            static::DEFAULT_OMS_PROCESS_NAME,
        );

        $shipmentTransfer = $this->haveShipment($saveOrderTransfer->getIdSalesOrderOrFail());
        $this->updateSalesOrderItemsWithIdShipment($saveOrderTransfer, $shipmentTransfer);

        return $this->getOrderTransfer($saveOrderTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\StockTransfer $warehouseTransfer
     * @param \ArrayObject<array-key, \Generated\Shared\Transfer\ItemTransfer> $itemTransfers
     * @param array<string, mixed> $seedData
     *
     * @return \Generated\Shared\Transfer\PickingListTransfer
     */
    public function createPickingList(StockTransfer $warehouseTransfer, ArrayObject $itemTransfers, array $seedData): PickingListTransfer
    {
        $pickingListTransfer = (new PickingListBuilder($seedData))->build();
        $pickingListTransfer->setWarehouse($warehouseTransfer);
        foreach ($itemTransfers as $itemTransfer) {
            $pickingListItemTransfer = (new PickingListItemBuilder([
                PickingListItemTransfer::ORDER_ITEM => $itemTransfer,
                PickingListItemTransfer::QUANTITY => $itemTransfer->getQuantityOrFail(),
            ]))->build();
            $pickingListTransfer->addPickingListItem($pickingListItemTransfer);
        }

        return $this->havePickingList($pickingListTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PickingListTransfer $pickingListTransfer
     *
     * @return void
     */
    public function finishPicking(PickingListTransfer $pickingListTransfer): void
    {
        foreach ($pickingListTransfer->getPickingListItems() as $pickingListItemTransfer) {
            $pickingListItemTransfer->setNumberOfPicked($pickingListItemTransfer->getQuantityOrFail());
        }

        $pickingListCollectionRequestTransfer = (new PickingListCollectionRequestTransfer())
            ->setIsTransactional(true)
            ->addPickingList($pickingListTransfer);

        $this->getLocator()->pickingList()->facade()->updatePickingListCollection($pickingListCollectionRequestTransfer);
    }

    /**
     * @param string $status
     *
     * @return void
     */
    public function seePickingListHaveCorrectStatus(string $status): void
    {
        $responseData = $this->grabJsonApiResponseJson();

        $this->assertEquals($status, $responseData['data']['attributes']['status']);
    }

    /**
     * @param string $status
     * @param int $index
     *
     * @return void
     */
    public function seeCollectionResponsePickingListHaveCorrectStatus(string $status, int $index = 0): void
    {
        $responseData = $this->grabJsonApiResponseJson();

        $this->assertEquals($status, $responseData['data'][$index]['attributes']['status']);
    }

    /**
     * @param \Generated\Shared\Transfer\PickingListTransfer $pickingListTransfer
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     *
     * @return void
     */
    public function seeUserIsAssignedToPickingList(PickingListTransfer $pickingListTransfer, UserTransfer $userTransfer): void
    {
        $pickingListQuery = $this->getPickingListQuery()
            ->filterByIdPickingList($pickingListTransfer->getIdPickingListOrFail())
            ->filterByUserUuid($userTransfer->getUuidOrFail());

        $this->assertTrue($pickingListQuery->exists());
    }

    /**
     * @return void
     */
    public function seePickingListNotFoundError(): void
    {
        $this->seeJsonApiResponseErrorsHaveCode(static::RESPONSE_CODE_ENTITY_NOT_FOUND);
        $this->seeJsonApiResponseErrorsHaveMessage(static::ERROR_DETAIL_PICKING_LIST_NOT_FOUND);
        $this->seeJsonApiResponseErrorsHaveStatus(HttpCode::NOT_FOUND);
    }

    /**
     * @param list<string> $includes
     *
     * @return string
     */
    public function getGetCollectionPickingListUrl(array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourcePickingLists}' . $this->formatQueryInclude($includes),
            [
                'resourcePickingLists' => PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
            ],
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PickingListTransfer $pickingListTransfer
     * @param list<string> $includes
     *
     * @return string
     */
    public function getGetPickingListUrl(PickingListTransfer $pickingListTransfer, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourcePickingLists}/{pickingListUuid}' . $this->formatQueryInclude($includes),
            [
                'resourcePickingLists' => PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
                'pickingListUuid' => $pickingListTransfer->getUuidOrFail(),
            ],
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PickingListTransfer $pickingListTransfer
     *
     * @return string
     */
    public function getPickingListItemUrl(
        PickingListTransfer $pickingListTransfer,
    ): string {
        return $this->formatFullUrl(
            '{resourcePickingLists}/{pickingListUuid}/{resourcePickingListItems}',
            [
                'resourcePickingLists' => PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
                'resourcePickingListItems' => PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                'pickingListUuid' => $pickingListTransfer->getUuidOrFail(),
            ],
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PickingListTransfer $pickingListTransfer
     *
     * @return string
     */
    public function getStartPickingUrl(PickingListTransfer $pickingListTransfer): string
    {
        return $this->formatFullUrl(
            '{resourcePickingLists}/{pickingListUuid}/{resourceStartPicking}',
            [
                'resourcePickingLists' => PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
                'resourceStartPicking' => PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_START_PICKING,
                'pickingListUuid' => $pickingListTransfer->getUuidOrFail(),
            ],
        );
    }

    /**
     * @param \Generated\Shared\Transfer\StockTransfer $warehouseTransfer
     * @param list<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteTransfers
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createQuoteTransfer(
        StockTransfer $warehouseTransfer,
        array $productConcreteTransfers,
    ): QuoteTransfer {
        $quoteTransfer = (new QuoteBuilder())
            ->withCustomer()
            ->withTotals()
            ->withShippingAddress()
            ->withBillingAddress()
            ->withCurrency()
            ->withPayment()
            ->build();

        foreach ($productConcreteTransfers as $productConcreteTransfer) {
            $itemTransfer = (new ItemBuilder([
                ItemTransfer::SKU => $productConcreteTransfer->getSku(),
                ItemTransfer::WAREHOUSE => $warehouseTransfer->toArray(),
            ]))->build();
            $quoteTransfer->addItem($itemTransfer);
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function getOrderTransfer(SaveOrderTransfer $saveOrderTransfer): OrderTransfer
    {
        /** @var \Spryker\Zed\Sales\Business\SalesFacadeInterface $salesFacade */
        $salesFacade = $this->getFacade('Sales');
        $orderFilterTransfer = (new OrderFilterTransfer())
            ->setSalesOrderId($saveOrderTransfer->getIdSalesOrderOrFail());

        return $salesFacade->getOrder($orderFilterTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     * @param \Generated\Shared\Transfer\ShipmentTransfer $shipmentTransfer
     *
     * @return void
     */
    protected function updateSalesOrderItemsWithIdShipment(SaveOrderTransfer $saveOrderTransfer, ShipmentTransfer $shipmentTransfer): void
    {
        $salesOrderItemEntities = $this->getSalesOrderItemQuery()
            ->filterByFkSalesOrder($saveOrderTransfer->getIdSalesOrderOrFail())
            ->find();

        foreach ($salesOrderItemEntities as $salesOrderItemEntity) {
            $salesOrderItemEntity->setFkSalesShipment($shipmentTransfer->getIdSalesShipmentOrFail());
            $salesOrderItemEntity->save();
        }
    }

    /**
     * @param list<string> $includes
     *
     * @return string
     */
    protected function formatQueryInclude(array $includes): string
    {
        if ($includes === []) {
            return '';
        }

        return sprintf('?%s=%s', static::QUERY_INCLUDE, implode(',', $includes));
    }

    /**
     * @return \Orm\Zed\PickingList\Persistence\SpyPickingListQuery
     */
    protected function getPickingListQuery(): SpyPickingListQuery
    {
        return SpyPickingListQuery::create();
    }

    /**
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderItemQuery
     */
    protected function getSalesOrderItemQuery(): SpySalesOrderItemQuery
    {
        return SpySalesOrderItemQuery::create();
    }
}
