<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures;

use Generated\Shared\Transfer\PickingListTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\UserTransfer;
use PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class PickingListItemsBackendJsonApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USER_PASSWORD = 'change123';

    /**
     * @uses \Spryker\Shared\PickingList\PickingListConfig::STATUS_READY_FOR_PICKING
     *
     * @var string
     */
    protected const STATUS_PICKING_STARTED = 'picking-started';

    /**
     * @var \Generated\Shared\Transfer\StockTransfer
     */
    protected StockTransfer $warehouseTransfer;

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $warehouseUserTransfer;

    /**
     * @var \Generated\Shared\Transfer\PickingListTransfer
     */
    protected PickingListTransfer $oneItemPickingListTransfer;

    /**
     * @var \Generated\Shared\Transfer\PickingListTransfer
     */
    protected PickingListTransfer $twoItemsPickingListTransfer;

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getWarehouseUserTransfer(): UserTransfer
    {
        return $this->warehouseUserTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PickingListTransfer
     */
    public function getOneItemPickingListTransfer(): PickingListTransfer
    {
        return $this->oneItemPickingListTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PickingListTransfer
     */
    public function getTwoItemsPickingListTransfer(): PickingListTransfer
    {
        return $this->twoItemsPickingListTransfer;
    }

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(PickingListsBackendApiTester $I): FixturesContainerInterface
    {
        $this->createWarehouse($I);
        $this->createUser($I);
        $this->createPickingLists($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    protected function createWarehouse(PickingListsBackendApiTester $I): void
    {
        $this->warehouseTransfer = $I->haveStock();
    }

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    protected function createUser(PickingListsBackendApiTester $I): void
    {
        $this->warehouseUserTransfer = $I->haveUser([
            UserTransfer::PASSWORD => static::TEST_USER_PASSWORD,
            UserTransfer::IS_WAREHOUSE_USER => true,
        ]);
        $I->haveWarehouseUserAssignment($this->warehouseUserTransfer, $this->warehouseTransfer);

        $this->warehouseUserTransfer->setPassword(static::TEST_USER_PASSWORD);
    }

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    protected function createPickingLists(PickingListsBackendApiTester $I): void
    {
        $productConcreteTransfer1 = $I->haveProduct();
        $productConcreteTransfer2 = $I->haveProduct();

        $oneItemOrderTransfer = $I->createOrder(
            $this->warehouseTransfer,
            [$productConcreteTransfer1],
        );
        $this->oneItemPickingListTransfer = $I->createPickingList(
            $this->warehouseTransfer,
            $oneItemOrderTransfer->getItems(),
            [
                PickingListTransfer::STATUS => static::STATUS_PICKING_STARTED,
                PickingListTransfer::USER_UUID => $this->warehouseUserTransfer->getUuidOrFail(),
                PickingListTransfer::USER => $this->warehouseUserTransfer->toArray(),
            ],
        );

        $twoItemsOrderTransfer = $I->createOrder(
            $this->warehouseTransfer,
            [
                $productConcreteTransfer1,
                $productConcreteTransfer2,
            ],
        );
        $this->twoItemsPickingListTransfer = $I->createPickingList(
            $this->warehouseTransfer,
            $twoItemsOrderTransfer->getItems(),
            [
                PickingListTransfer::STATUS => static::STATUS_PICKING_STARTED,
                PickingListTransfer::USER_UUID => $this->warehouseUserTransfer->getUuidOrFail(),
                PickingListTransfer::USER => $this->warehouseUserTransfer->toArray(),
            ],
        );
    }
}
