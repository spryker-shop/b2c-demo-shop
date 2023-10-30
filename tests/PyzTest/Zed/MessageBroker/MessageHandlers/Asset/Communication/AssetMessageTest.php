<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\Asset\Communication;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AssetAddedTransfer;
use Generated\Shared\Transfer\AssetDeletedTransfer;
use Generated\Shared\Transfer\AssetUpdatedTransfer;
use PyzTest\Zed\MessageBroker\AssetCommunicationTester;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group MessageBroker
 * @group MessageHandlers
 * @group Asset
 * @group Communication
 * @group AssetMessageTest
 * Add your own group annotations below this line
 */
class AssetMessageTest extends Unit
{
    /**
     * @var \PyzTest\Zed\MessageBroker\AssetCommunicationTester
     */
    protected AssetCommunicationTester $tester;

    /**
     * @return void
     */
    public function testAssetAddedMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $assetUuid = Uuid::uuid4()->toString();
        $slotName = 'slt-footer';
        $channelName = 'asset-commands';

        $assetAddedTransfer = $this->tester->generateAssetAddedTransfer([
            AssetAddedTransfer::ASSET_SLOT => $slotName,
            AssetAddedTransfer::ASSET_IDENTIFIER => $assetUuid,
        ]);

        // Act
        $this->tester->setupMessageBroker($assetAddedTransfer::class, $channelName);
        $messageBrokerFacade = $this->tester->getLocator()->messageBroker()->facade();
        $messageBrokerFacade->sendMessage($assetAddedTransfer);
        $messageBrokerFacade->startWorker($this->tester->buildMessageBrokerWorkerConfigTransfer([$channelName], 1));

        // Assert
        $asset = $this->tester->findAssetByUuid($assetUuid);
        $this->tester->assertNotNull($asset);
        $this->tester->assertSame($slotName, $asset->getAssetSlot());
    }

    /**
     * @return void
     */
    public function testAssetUpdatedMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $channelName = 'asset-commands';
        $assetUuid = Uuid::uuid4()->toString();
        $slotName = 'header-top';

        $this->tester->setupMessageBroker(AssetAddedTransfer::class, $channelName);
        $messageBrokerFacade = $this->tester->getLocator()->messageBroker()->facade();
        $messageBrokerWorkerConfigTransfer = $this->tester->buildMessageBrokerWorkerConfigTransfer([$channelName], 1);
        $messageBrokerFacade->sendMessage(
            $this->tester->generateAssetAddedTransfer([
                AssetAddedTransfer::ASSET_SLOT => 'slt-footer',
                AssetAddedTransfer::ASSET_IDENTIFIER => $assetUuid,
            ]),
        );
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);
        $this->tester->resetInMemoryMessages();

        // Act
        $this->tester->setupMessageBroker(AssetUpdatedTransfer::class, $channelName);
        $messageBrokerFacade->sendMessage(
            $this->tester->generateAssetUpdatedTransfer([
                AssetUpdatedTransfer::ASSET_SLOT => $slotName,
                AssetUpdatedTransfer::ASSET_IDENTIFIER => $assetUuid,
            ]),
        );
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);

        // Assert
        $asset = $this->tester->findAssetByUuid($assetUuid);
        $this->tester->assertNotNull($asset);
        $this->tester->assertSame($slotName, $asset->getAssetSlot());
    }

    /**
     * @return void
     */
    public function testAssetDeletedMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $channelName = 'asset-commands';
        $assetUuid = Uuid::uuid4()->toString();

        $this->tester->setupMessageBroker(AssetAddedTransfer::class, $channelName);
        $messageBrokerFacade = $this->tester->getLocator()->messageBroker()->facade();
        $messageBrokerWorkerConfigTransfer = $this->tester->buildMessageBrokerWorkerConfigTransfer([$channelName], 1);
        $messageBrokerFacade->sendMessage(
            $this->tester->generateAssetAddedTransfer([
                AssetAddedTransfer::ASSET_IDENTIFIER => $assetUuid,
            ]),
        );
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);
        $this->tester->resetInMemoryMessages();

        // Act
        $this->tester->setupMessageBroker(AssetDeletedTransfer::class, $channelName);
        $messageBrokerFacade->sendMessage(
            $this->tester->generateAssetDeletedTransfer([
                AssetDeletedTransfer::ASSET_IDENTIFIER => $assetUuid,
            ]),
        );
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);

        // Assert
        $this->tester->assertFalse($this->tester->findAssetByUuid($assetUuid)->getIsActive());
    }
}
