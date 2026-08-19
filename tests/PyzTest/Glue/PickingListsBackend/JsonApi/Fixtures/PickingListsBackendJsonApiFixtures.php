<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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

    protected UserTransfer $warehouseUserTransfer;

    protected UserTransfer $warehouseUserTransferWithoutAssignment;

    protected UserTransfer $userTransfer;

    protected StockTransfer $warehouseTransfer;

    protected ProductConcreteTransfer $productConcreteTransfer;

    protected OrderTransfer $orderTransfer1;

    protected OrderTransfer $orderTransfer2;

    protected PickingListTransfer $readyForPickingPickingListTransfer;

    protected PickingListTransfer $pickingStartedPickingListTransfer;

    public function getWarehouseUserTransfer(): UserTransfer
    {
        return $this->warehouseUserTransfer;
    }

    public function getWarehouseUserTransferWithoutAssignment(): UserTransfer
    {
        return $this->warehouseUserTransferWithoutAssignment;
    }

    public function getUserTransfer(): UserTransfer
    {
        return $this->userTransfer;
    }

    public function getWarehouseTransfer(): StockTransfer
    {
        return $this->warehouseTransfer;
    }

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function getOrderTransfer1(): OrderTransfer
    {
        return $this->orderTransfer1;
    }

    public function getOrderTransfer2(): OrderTransfer
    {
        return $this->orderTransfer2;
    }

    public function getReadyForPickingPickingListTransfer(): PickingListTransfer
    {
        return $this->readyForPickingPickingListTransfer;
    }

    public function getPickingStartedPickingListTransfer(): PickingListTransfer
    {
        return $this->pickingStartedPickingListTransfer;
    }

    public function buildFixtures(PickingListsBackendApiTester $I): FixturesContainerInterface
    {
        $this->createWarehouse($I);
        $this->createUsers($I);
        $this->createProduct($I);
        $this->createOrders($I);
        $this->createPickingLists($I);

        return $this;
    }

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

    protected function createWarehouse(PickingListsBackendApiTester $I): void
    {
        $this->warehouseTransfer = $I->haveStock();
    }

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
