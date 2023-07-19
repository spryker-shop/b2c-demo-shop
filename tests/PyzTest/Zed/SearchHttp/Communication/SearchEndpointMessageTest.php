<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\SearchHttp\Communication;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\MessageAttributesTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PyzTest\Zed\SearchHttp\SearchHttpTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group SearchHttp
 * @group Communication
 * @group SearchEndpointMessageTest
 * Add your own group annotations below this line
 */
class SearchEndpointMessageTest extends Unit
{
    /**
     * @var string
     */
    protected const STORE_REFERENCE = 'dev-DE';

    /**
     * @var \PyzTest\Zed\SearchHttp\SearchHttpTester
     */
    protected SearchHttpTester $tester;

    /**
     * @return void
     */
    public function testSearchEndpointAvailableMessageIsSuccessfullyHandled(): void
    {
        if ($this->tester->seeThatDynamicStoreEnabled()) {
            $this->tester->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);

        $this->tester->removeHttpConfigForStore($storeTransfer);
        $searchEndpointAvailableTransfer = $this->tester->buildSearchEndpointAvailableTransfer([
            MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
            MessageAttributesTransfer::EMITTER => 'test',
        ]);

        // Act
        $this->tester->handleSearchMessage($searchEndpointAvailableTransfer);

        // Assert
        $this->tester->assertSearchHttpConfigExistsForStore($storeTransfer);
    }

    /**
     * @return void
     */
    public function testSearchEndpointRemovedMessageIsSuccessfullyHandled(): void
    {
        if ($this->tester->seeThatDynamicStoreEnabled()) {
            $this->tester->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);

        $emitter = 'test';
        $this->createDummySearchHttpConfig($storeTransfer, $emitter);

        $searchEndpointRemovedTransfer = $this->tester->buildSearchEndpointRemovedTransfer([
            MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
            MessageAttributesTransfer::EMITTER => $emitter,
        ]);

        // Act
        $this->tester->handleSearchMessage($searchEndpointRemovedTransfer);

        // Assert
        $this->tester->assertSearchHttpConfigIsRemovedForStore($storeTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param string $emitter
     *
     * @return void
     */
    protected function createDummySearchHttpConfig(StoreTransfer $storeTransfer, string $emitter): void
    {
        $this->tester->removeHttpConfigForStore($storeTransfer);
        $this->tester->handleSearchMessage(
            $this->tester->buildSearchEndpointAvailableTransfer([
                MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
                MessageAttributesTransfer::EMITTER => $emitter,
            ]),
        );
    }
}
