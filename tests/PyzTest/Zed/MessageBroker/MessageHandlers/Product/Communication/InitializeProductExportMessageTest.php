<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\Product\Communication;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\EventEntityTransfer;
use Generated\Shared\Transfer\InitializeProductExportTransfer;
use PyzTest\Zed\MessageBroker\ProductCommunicationTester;
use Spryker\Zed\Product\Business\ProductBusinessFactory;
use Spryker\Zed\Product\Dependency\Facade\ProductToEventInterface;
use Spryker\Zed\Product\Dependency\ProductEvents;
use Spryker\Zed\Product\ProductDependencyProvider;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group MessageBroker
 * @group MessageHandlers
 * @group Product
 * @group Communication
 * @group InitializeProductExportMessageTest
 * Add your own group annotations below this line
 */
class InitializeProductExportMessageTest extends Unit
{
    /**
     * @var \PyzTest\Zed\MessageBroker\ProductCommunicationTester
     */
    protected ProductCommunicationTester $tester;

    /**
     * @return void
     */
    public function testInitializeProductExportMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $eventFacadeMock = $this->createMock(ProductToEventInterface::class);
        $this->tester->setDependency(
            ProductDependencyProvider::FACADE_EVENT,
            $eventFacadeMock,
            ProductBusinessFactory::class,
        );
        $this->tester->haveFullProduct();
        $channelName = 'product-commands';

        // Assert
        $eventFacadeMock->expects($this->atLeastOnce())->method('triggerBulk')->with(
            $this->identicalTo(ProductEvents::PRODUCT_CONCRETE_EXPORT),
            $this->callback(function (array $transfers) {
                $this->assertIsArray($transfers);
                $this->assertGreaterThanOrEqual(1, count($transfers));
                $this->assertInstanceOf(EventEntityTransfer::class, $transfers[0]);

                return true;
            }),
        );

        // Act
        $this->tester->setupMessageBroker(InitializeProductExportTransfer::class, $channelName);
        $messageBrokerFacade = $this->tester->getLocator()->messageBroker()->facade();
        $messageBrokerFacade->sendMessage(
            $this->tester->buildInitializeProductExportTransfer(),
        );
        $messageBrokerFacade->startWorker(
            $this->tester->buildMessageBrokerWorkerConfigTransfer([$channelName], 1),
        );
    }
}
