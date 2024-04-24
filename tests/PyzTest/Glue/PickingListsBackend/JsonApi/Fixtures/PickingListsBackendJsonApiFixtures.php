<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures;

use Generated\Shared\DataBuilder\ProductImageBuilder;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PickingListTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductImageSetTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Generated\Shared\Transfer\UserTransfer;
use PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class PickingListsBackendJsonApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
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
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $warehouseUserTransfer;

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $warehouseUserTransferWithoutAssignment;

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $userTransfer;

    /**
     * @var \Generated\Shared\Transfer\StockTransfer
     */
    protected StockTransfer $warehouseTransfer;

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productConcreteTransfer;

    /**
     * @var \Generated\Shared\Transfer\OrderTransfer
     */
    protected OrderTransfer $orderTransfer1;

    /**
     * @var \Generated\Shared\Transfer\OrderTransfer
     */
    protected OrderTransfer $orderTransfer2;

    /**
     * @var \Generated\Shared\Transfer\PickingListTransfer
     */
    protected PickingListTransfer $readyForPickingPickingListTransfer;

    /**
     * @var \Generated\Shared\Transfer\PickingListTransfer
     */
    protected PickingListTransfer $pickingStartedPickingListTransfer;

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getWarehouseUserTransfer(): UserTransfer
    {
        return $this->warehouseUserTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getWarehouseUserTransferWithoutAssignment(): UserTransfer
    {
        return $this->warehouseUserTransferWithoutAssignment;
    }

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getUserTransfer(): UserTransfer
    {
        return $this->userTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\StockTransfer
     */
    public function getWarehouseTransfer(): StockTransfer
    {
        return $this->warehouseTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    /**
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderTransfer1(): OrderTransfer
    {
        return $this->orderTransfer1;
    }

    /**
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderTransfer2(): OrderTransfer
    {
        return $this->orderTransfer2;
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
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(PickingListsBackendApiTester $I): FixturesContainerInterface
    {
        $this->createWarehouse($I);
        $this->createUsers($I);
        $this->createProduct($I);
        $this->createOrders($I);
        $this->createPickingLists($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    protected function createUsers(PickingListsBackendApiTester $I): void
    {
        $this->warehouseUserTransfer = $I->haveUser([
            UserTransfer::PASSWORD => static::TEST_USER_PASSWORD,
            UserTransfer::IS_WAREHOUSE_USER => true,
        ]);
        $I->haveWarehouseUserAssignment($this->warehouseUserTransfer, $this->warehouseTransfer);

        $this->warehouseUserTransferWithoutAssignment = $I->haveUser([
            UserTransfer::PASSWORD => static::TEST_USER_PASSWORD,
            UserTransfer::IS_WAREHOUSE_USER => true,
        ]);

        $this->userTransfer = $I->haveUser([
            UserTransfer::PASSWORD => static::TEST_USER_PASSWORD,
            UserTransfer::IS_WAREHOUSE_USER => false,
        ]);

        $this->warehouseUserTransfer->setPassword(static::TEST_USER_PASSWORD);
        $this->warehouseUserTransferWithoutAssignment->setPassword(static::TEST_USER_PASSWORD);
        $this->userTransfer->setPassword(static::TEST_USER_PASSWORD);
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
    protected function createProduct(PickingListsBackendApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();
        $productImageSetTransfer = $I->haveProductImageSet([
            ProductImageSetTransfer::ID_PRODUCT => $this->productConcreteTransfer->getIdProductConcreteOrFail(),
            ProductImageSetTransfer::SKU => $this->productConcreteTransfer->getSkuOrFail(),
            ProductImageSetTransfer::PRODUCT_IMAGES => [
                (new ProductImageBuilder())->build(),
                (new ProductImageBuilder())->build(),
            ],
        ]);

        $this->productConcreteTransfer->addImageSet($productImageSetTransfer);
    }

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    protected function createOrders(PickingListsBackendApiTester $I): void
    {
        $this->orderTransfer1 = $I->createOrder(
            $this->warehouseTransfer,
            [$this->productConcreteTransfer],
        );

        $this->orderTransfer2 = $I->createOrder(
            $this->warehouseTransfer,
            [$this->productConcreteTransfer],
        );
    }

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    protected function createPickingLists(PickingListsBackendApiTester $I): void
    {
        $this->readyForPickingPickingListTransfer = $I->createPickingList(
            $this->warehouseTransfer,
            $this->orderTransfer1->getItems(),
            [PickingListTransfer::STATUS => static::STATUS_READY_FOR_PICKING],
        );

        $this->pickingStartedPickingListTransfer = $I->createPickingList(
            $this->warehouseTransfer,
            $this->orderTransfer2->getItems(),
            [
                PickingListTransfer::STATUS => static::STATUS_PICKING_STARTED,
                PickingListTransfer::USER_UUID => $this->warehouseUserTransfer->getUuidOrFail(),
                PickingListTransfer::USER => $this->warehouseUserTransfer->toArray(),
            ],
        );
    }
}
