<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures;

use Generated\Shared\Transfer\PickingListTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\UserTransfer;
use Generated\Shared\Transfer\WarehouseUserAssignmentTransfer;
use PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class StartPickingBackendJsonApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
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
    protected const STATUS_READY_FOR_PICKING = 'ready-for-picking';

    /**
     * @uses \Spryker\Shared\PickingList\PickingListConfig::STATUS_READY_FOR_PICKING
     *
     * @var string
     */
    protected const STATUS_PICKING_STARTED = 'picking-started';

    /**
     * @uses \Spryker\Shared\PickingList\PickingListConfig::STATUS_PICKING_FINISHED
     *
     * @var string
     */
    protected const STATUS_PICKING_FINISHED = 'picking-finished';

    /**
     * @var \Generated\Shared\Transfer\StockTransfer
     */
    protected StockTransfer $warehouseTransfer;

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $mainWarehouseUserTransfer;

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $secondaryWarehouseUserTransfer;

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $withInactiveAssignmentWarehouseUserTransfer;

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $withoutAssignmentWarehouseUserTransfer;

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $notWarehouseUserTransfer;

    /**
     * @var \Generated\Shared\Transfer\PickingListTransfer
     */
    protected PickingListTransfer $readyForPickingPickingListTransfer;

    /**
     * @var \Generated\Shared\Transfer\PickingListTransfer
     */
    protected PickingListTransfer $pickingStartedPickingListTransfer;

    /**
     * @var \Generated\Shared\Transfer\PickingListTransfer
     */
    protected PickingListTransfer $pickingFinishedPickingListTransfer;

    /**
     * @var \Generated\Shared\Transfer\PickingListTransfer
     */
    protected PickingListTransfer $immutableReadyForPickingPickingListTransfer;

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getMainWarehouseUserTransfer(): UserTransfer
    {
        return $this->mainWarehouseUserTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getSecondaryWarehouseUserTransfer(): UserTransfer
    {
        return $this->secondaryWarehouseUserTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getWithInactiveAssignmentWarehouseUserTransfer(): UserTransfer
    {
        return $this->withInactiveAssignmentWarehouseUserTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getWithoutAssignmentWarehouseUserTransfer(): UserTransfer
    {
        return $this->withoutAssignmentWarehouseUserTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getNotWarehouseUserTransfer(): UserTransfer
    {
        return $this->notWarehouseUserTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PickingListTransfer
     */
    public function getReadyForPickingPickingListTransfer(): PickingListTransfer
    {
        return $this->readyForPickingPickingListTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PickingListTransfer
     */
    public function getPickingStartedPickingListTransfer(): PickingListTransfer
    {
        return $this->pickingStartedPickingListTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PickingListTransfer
     */
    public function getPickingFinishedPickingListTransfer(): PickingListTransfer
    {
        return $this->pickingFinishedPickingListTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\PickingListTransfer
     */
    public function getImmutableReadyForPickingPickingListTransfer(): PickingListTransfer
    {
        return $this->immutableReadyForPickingPickingListTransfer;
    }

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(PickingListsBackendApiTester $I): FixturesContainerInterface
    {
        $this->createWarehouse($I);
        $this->createUsers($I);
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
    protected function createUsers(PickingListsBackendApiTester $I): void
    {
        $this->mainWarehouseUserTransfer = $I->haveUser([
            UserTransfer::PASSWORD => static::TEST_USER_PASSWORD,
            UserTransfer::IS_WAREHOUSE_USER => true,
        ]);
        $I->haveWarehouseUserAssignment($this->mainWarehouseUserTransfer, $this->warehouseTransfer);

        $this->secondaryWarehouseUserTransfer = $I->haveUser([
            UserTransfer::PASSWORD => static::TEST_USER_PASSWORD,
            UserTransfer::IS_WAREHOUSE_USER => true,
        ]);
        $I->haveWarehouseUserAssignment($this->secondaryWarehouseUserTransfer, $this->warehouseTransfer);

        $this->withInactiveAssignmentWarehouseUserTransfer = $I->haveUser([
            UserTransfer::PASSWORD => static::TEST_USER_PASSWORD,
            UserTransfer::IS_WAREHOUSE_USER => true,
        ]);
        $I->haveWarehouseUserAssignment($this->withInactiveAssignmentWarehouseUserTransfer, $this->warehouseTransfer, [
            WarehouseUserAssignmentTransfer::IS_ACTIVE => false,
        ]);

        $this->withoutAssignmentWarehouseUserTransfer = $I->haveUser([
            UserTransfer::PASSWORD => static::TEST_USER_PASSWORD,
            UserTransfer::IS_WAREHOUSE_USER => true,
        ]);

        $this->notWarehouseUserTransfer = $I->haveUser([
            UserTransfer::PASSWORD => static::TEST_USER_PASSWORD,
            UserTransfer::IS_WAREHOUSE_USER => false,
        ]);

        $this->mainWarehouseUserTransfer->setPassword(static::TEST_USER_PASSWORD);
        $this->secondaryWarehouseUserTransfer->setPassword(static::TEST_USER_PASSWORD);
        $this->withoutAssignmentWarehouseUserTransfer->setPassword(static::TEST_USER_PASSWORD);
        $this->withInactiveAssignmentWarehouseUserTransfer->setPassword(static::TEST_USER_PASSWORD);
        $this->notWarehouseUserTransfer->setPassword(static::TEST_USER_PASSWORD);
    }

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    protected function createPickingLists(PickingListsBackendApiTester $I): void
    {
        $productConcreteTransfer = $I->haveProduct();

        $orderTransfer1 = $I->createOrder($this->warehouseTransfer, [$productConcreteTransfer]);
        $this->readyForPickingPickingListTransfer = $I->createPickingList(
            $this->warehouseTransfer,
            $orderTransfer1->getItems(),
            [
                PickingListTransfer::STATUS => static::STATUS_READY_FOR_PICKING,
                PickingListTransfer::USER_UUID => $this->mainWarehouseUserTransfer->getUuidOrFail(),
                PickingListTransfer::USER => $this->mainWarehouseUserTransfer->toArray(),
            ],
        );

        $orderTransfer2 = $I->createOrder($this->warehouseTransfer, [$productConcreteTransfer]);
        $this->pickingStartedPickingListTransfer = $I->createPickingList(
            $this->warehouseTransfer,
            $orderTransfer2->getItems(),
            [
                PickingListTransfer::STATUS => static::STATUS_PICKING_STARTED,
                PickingListTransfer::USER_UUID => $this->mainWarehouseUserTransfer->getUuidOrFail(),
                PickingListTransfer::USER => $this->mainWarehouseUserTransfer->toArray(),
            ],
        );

        $orderTransfer3 = $I->createOrder($this->warehouseTransfer, [$productConcreteTransfer]);
        $this->pickingFinishedPickingListTransfer = $I->createPickingList(
            $this->warehouseTransfer,
            $orderTransfer3->getItems(),
            [
                PickingListTransfer::STATUS => static::STATUS_PICKING_FINISHED,
                PickingListTransfer::USER_UUID => $this->mainWarehouseUserTransfer->getUuidOrFail(),
                PickingListTransfer::USER => $this->mainWarehouseUserTransfer->toArray(),
            ],
        );
        $I->finishPicking($this->pickingFinishedPickingListTransfer);

        $orderTransfer4 = $I->createOrder($this->warehouseTransfer, [$productConcreteTransfer]);
        $this->immutableReadyForPickingPickingListTransfer = $I->createPickingList(
            $this->warehouseTransfer,
            $orderTransfer4->getItems(),
            [PickingListTransfer::STATUS => static::STATUS_READY_FOR_PICKING],
        );
    }
}
