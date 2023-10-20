<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\SearchHttp\Communication;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\MessageAttributesTransfer;
use PyzTest\Zed\MessageBroker\SearchHttpCommunicationTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group MessageBroker
 * @group MessageHandlers
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
     * @var \PyzTest\Zed\MessageBroker\SearchHttpCommunicationTester
     */
    protected SearchHttpCommunicationTester $tester;

    /**
     * @return void
     */
    public function testSearchEndpointAvailableMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $messageAttributesData = [
            MessageAttributesTransfer::EMITTER => 'test',
        ];

        $storeTransfer = $this->tester->getAllowedStore();

        if (!$this->tester->isDynamicStoreEnabled()) {
            $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);
            $messageAttributesData[MessageAttributesTransfer::STORE_REFERENCE] = static::STORE_REFERENCE;
        }

        $this->tester->removeHttpConfigForStore($storeTransfer);
        $searchEndpointAvailableTransfer = $this->tester->buildSearchEndpointAvailableTransfer($messageAttributesData);

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
        // Arrange
        $emitter = 'test';
        $messageAttributesData = [
            MessageAttributesTransfer::EMITTER => $emitter,
        ];

        $storeTransfer = $this->tester->getAllowedStore();

        if (!$this->tester->isDynamicStoreEnabled()) {
            $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);
            $messageAttributesData[MessageAttributesTransfer::STORE_REFERENCE] = static::STORE_REFERENCE;
        }

        $this->tester->removeHttpConfigForStore($storeTransfer);
        $this->tester->handleSearchMessage(
            $this->tester->buildSearchEndpointAvailableTransfer([
                MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
                MessageAttributesTransfer::EMITTER => $emitter,
            ]),
        );

        $searchEndpointRemovedTransfer = $this->tester->buildSearchEndpointRemovedTransfer($messageAttributesData);

        // Act
        $this->tester->handleSearchMessage($searchEndpointRemovedTransfer);

        // Assert
        $this->tester->assertSearchHttpConfigIsRemovedForStore($storeTransfer);
    }
}
