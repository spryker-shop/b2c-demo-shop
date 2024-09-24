<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\SearchHttp\Communication;

use Codeception\Test\Unit;
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
     * @var \PyzTest\Zed\MessageBroker\SearchHttpCommunicationTester
     */
    protected SearchHttpCommunicationTester $tester;

    /**
     * @return void
     */
    public function testSearchEndpointAvailableMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->removeHttpConfigForStore($storeTransfer);
        $searchEndpointAvailableTransfer = $this->tester->buildSearchEndpointAvailableTransfer();

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
        $storeTransfer = $this->tester->getAllowedStore();

        $this->tester->removeHttpConfigForStore($storeTransfer);
        $this->tester->handleSearchMessage(
            $this->tester->buildSearchEndpointAvailableTransfer(),
        );

        $searchEndpointRemovedTransfer = $this->tester->buildSearchEndpointRemovedTransfer();

        // Act
        $this->tester->handleSearchMessage($searchEndpointRemovedTransfer);

        // Assert
        $this->tester->assertSearchHttpConfigIsRemovedForStore($storeTransfer);
    }
}
