<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\DataImport\Business\Model\ProductStock;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\ProductStockPropelDataSetWriter;
use ReflectionMethod;
use ReflectionProperty;
use Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface;
use Spryker\Zed\Stock\Business\StockFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group DataImport
 * @group Business
 * @group Model
 * @group ProductStock
 * @group ProductStockPropelDataSetWriterStoreWarehouseMappingTest
 * Add your own group annotations below this line
 */
class ProductStockPropelDataSetWriterStoreWarehouseMappingTest extends Unit
{
    protected const string STORE_NAME_DE = 'DE';

    protected const string STORE_NAME_AT = 'AT';

    /**
     * @var array<string, array<string>>
     */
    protected const array STORE_TO_WAREHOUSE_MAPPING = [
        self::STORE_NAME_DE => ['Warehouse1', 'Warehouse2'],
        self::STORE_NAME_AT => ['Warehouse2'],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->resetStoreToWarehouseMappingCache();
    }

    protected function tearDown(): void
    {
        $this->resetStoreToWarehouseMappingCache();

        parent::tearDown();
    }

    public function testGetStoreWarehousesReadsTheStoreToWarehouseMappingOnlyOnceForManyRowsAndStores(): void
    {
        // Arrange
        $stockFacadeMock = $this->createStockFacadeMock();
        $stockFacadeMock->expects($this->once())
            ->method('getStoreToWarehouseMapping')
            ->willReturn(static::STORE_TO_WAREHOUSE_MAPPING);

        $productStockPropelDataSetWriter = $this->createProductStockPropelDataSetWriter($stockFacadeMock);

        // Act
        $warehousesPerCall = [];
        for ($row = 0; $row < 3; $row++) {
            $warehousesPerCall[] = $this->callGetStoreWarehouses($productStockPropelDataSetWriter, static::STORE_NAME_DE);
            $warehousesPerCall[] = $this->callGetStoreWarehouses($productStockPropelDataSetWriter, static::STORE_NAME_AT);
        }
        $warehousesOfUnknownStore = $this->callGetStoreWarehouses($productStockPropelDataSetWriter, 'US');

        // Assert
        $this->assertSame(['Warehouse1', 'Warehouse2'], $warehousesPerCall[4]);
        $this->assertSame(['Warehouse2'], $warehousesPerCall[5]);
        $this->assertSame([], $warehousesOfUnknownStore);
    }

    public function testFlushMakesTheWriterReadTheStoreToWarehouseMappingAgain(): void
    {
        // Arrange
        $stockFacadeMock = $this->createStockFacadeMock();
        $stockFacadeMock->expects($this->exactly(2))
            ->method('getStoreToWarehouseMapping')
            ->willReturnOnConsecutiveCalls(
                static::STORE_TO_WAREHOUSE_MAPPING,
                [static::STORE_NAME_DE => ['Warehouse1', 'Warehouse2', 'Warehouse3']],
            );

        $productStockPropelDataSetWriter = $this->createProductStockPropelDataSetWriter($stockFacadeMock);

        // Act
        $warehousesBeforeFlush = $this->callGetStoreWarehouses($productStockPropelDataSetWriter, static::STORE_NAME_DE);
        $productStockPropelDataSetWriter->flush();
        $warehousesAfterFlush = $this->callGetStoreWarehouses($productStockPropelDataSetWriter, static::STORE_NAME_DE);

        // Assert
        $this->assertSame(['Warehouse1', 'Warehouse2'], $warehousesBeforeFlush);
        $this->assertSame(['Warehouse1', 'Warehouse2', 'Warehouse3'], $warehousesAfterFlush);
    }

    protected function createStockFacadeMock(): StockFacadeInterface&MockObject
    {
        return $this->getMockBuilder(StockFacadeInterface::class)->getMock();
    }

    protected function createProductStockPropelDataSetWriter(StockFacadeInterface $stockFacade): ProductStockPropelDataSetWriter
    {
        // The publish events part of flush() reads the database; it is not part of this test.
        return new class (
            $this->getMockBuilder(ProductBundleFacadeInterface::class)->getMock(),
            $this->getMockBuilder(ProductRepositoryInterface::class)->getMock(),
            $this->getMockBuilder(StoreFacadeInterface::class)->getMock(),
            $stockFacade,
        ) extends ProductStockPropelDataSetWriter {
            protected function triggerAvailabilityPublishEvents(): void
            {
            }
        };
    }

    /**
     * @return array<string>
     */
    protected function callGetStoreWarehouses(
        ProductStockPropelDataSetWriter $productStockPropelDataSetWriter,
        string $storeName,
    ): array {
        return (new ReflectionMethod($productStockPropelDataSetWriter, 'getStoreWarehouses'))
            ->invoke($productStockPropelDataSetWriter, $storeName);
    }

    protected function resetStoreToWarehouseMappingCache(): void
    {
        (new ReflectionProperty(ProductStockPropelDataSetWriter::class, 'storeToWarehouseMapping'))->setValue(null, null);
    }
}
