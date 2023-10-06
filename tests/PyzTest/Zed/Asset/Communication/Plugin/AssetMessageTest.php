<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Asset\Communication\Plugin;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\AssetAddedTransfer;
use Generated\Shared\Transfer\AssetDeletedTransfer;
use Generated\Shared\Transfer\AssetUpdatedTransfer;
use Generated\Shared\Transfer\MessageAttributesTransfer;
use PyzTest\Zed\Asset\AssetTester;
use Ramsey\Uuid\Uuid;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group Asset
 * @group Communication
 * @group Plugin
 * @group AssetMessageTest
 * Add your own group annotations below this line
 */
class AssetMessageTest extends Unit
{
    /**
     * @var string
     */
    protected const STORE_REFERENCE = 'dev-DE';

    /**
     * @var \PyzTest\Zed\Asset\AssetTester
     */
    protected AssetTester $tester;

    /**
     * @return void
     */
    public function testAssetAddedMessageIsSuccessfullyHandled(): void
    {
        if ($this->tester->seeThatDynamicStoreEnabled()) {
            $this->tester->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $assetUuid = Uuid::uuid4()->toString();
        $slotName = 'slt-footer';

        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);

        $assetAddedTransfer = $this->tester->generateAssetAddedTransfer([
            AssetAddedTransfer::ASSET_SLOT => $slotName,
            AssetAddedTransfer::ASSET_IDENTIFIER => $assetUuid,
            AssetAddedTransfer::MESSAGE_ATTRIBUTES => [
                MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
            ],
        ]);

        // Act
        $messageBrokerFacade = $this->tester->getLocator()->messageBroker()->facade();
        $messageBrokerFacade->sendMessage($assetAddedTransfer);
        $messageBrokerFacade->startWorker($this->tester->buildMessageBrokerWorkerConfigTransfer(['assets'], 1));

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
        if ($this->tester->seeThatDynamicStoreEnabled()) {
            $this->tester->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $assetUuid = Uuid::uuid4()->toString();
        $slotName = 'header-top';

        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);
        $messageBrokerFacade = $this->tester->getLocator()->messageBroker()->facade();
        $messageBrokerWorkerConfigTransfer = $this->tester->buildMessageBrokerWorkerConfigTransfer(['assets'], 1);
        $messageBrokerFacade->sendMessage(
            $this->tester->generateAssetAddedTransfer([
                AssetAddedTransfer::ASSET_SLOT => 'slt-footer',
                AssetAddedTransfer::ASSET_IDENTIFIER => $assetUuid,
                AssetAddedTransfer::MESSAGE_ATTRIBUTES => [
                    MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
                ],
            ]),
        );
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);
        $this->tester->resetInMemoryMessages();

        // Act
        $messageBrokerFacade->sendMessage(
            $this->tester->generateAssetUpdatedTransfer([
                AssetUpdatedTransfer::ASSET_SLOT => $slotName,
                AssetUpdatedTransfer::ASSET_IDENTIFIER => $assetUuid,
                AssetUpdatedTransfer::MESSAGE_ATTRIBUTES => [
                    MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
                ],
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
        if ($this->tester->seeThatDynamicStoreEnabled()) {
            $this->tester->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $assetUuid = Uuid::uuid4()->toString();

        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);

        $messageBrokerFacade = $this->tester->getLocator()->messageBroker()->facade();
        $messageBrokerWorkerConfigTransfer = $this->tester->buildMessageBrokerWorkerConfigTransfer(['assets'], 1);
        $messageBrokerFacade->sendMessage(
            $this->tester->generateAssetAddedTransfer([
                AssetAddedTransfer::ASSET_IDENTIFIER => $assetUuid,
                AssetAddedTransfer::MESSAGE_ATTRIBUTES => [
                    MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
                ],
            ]),
        );
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);
        $this->tester->resetInMemoryMessages();

        // Act
        $messageBrokerFacade->sendMessage(
            $this->tester->generateAssetDeletedTransfer([
                AssetDeletedTransfer::ASSET_IDENTIFIER => $assetUuid,
                AssetDeletedTransfer::MESSAGE_ATTRIBUTES => [
                    MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
                ],
            ]),
        );
        $messageBrokerFacade->startWorker($messageBrokerWorkerConfigTransfer);

        // Assert
        $this->tester->assertFalse($this->tester->findAssetByUuid($assetUuid)->getIsActive());
    }
}
