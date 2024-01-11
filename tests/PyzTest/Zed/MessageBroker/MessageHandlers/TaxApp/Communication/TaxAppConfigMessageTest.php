<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\MessageBroker\MessageHandlers\TaxApp\Communication;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ConfigureTaxAppTransfer;
use Generated\Shared\Transfer\DeleteTaxAppTransfer;
use Generated\Shared\Transfer\MessageAttributesTransfer;
use PyzTest\Zed\MessageBroker\TaxAppCommunicationTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group MessageBroker
 * @group MessageHandlers
 * @group TaxApp
 * @group Communication
 * @group TaxAppConfigMessageTest
 * Add your own group annotations below this line
 */
class TaxAppConfigMessageTest extends Unit
{
    /**
     * @var string
     */
    protected const STORE_REFERENCE = 'DE';

    /**
     * @var string
     */
    protected const VENDOR_CODE = 'VENDOR_CODE';

    /**
     * @var \PyzTest\Zed\MessageBroker\TaxAppCommunicationTester
     */
    protected TaxAppCommunicationTester $tester;

    /**
     * @return void
     */
    public function testConfigureTaxAppMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);

        $configureTaxAppTransfer = $this->tester->buildConfigureTaxAppTransfer([
            MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
        ], [
            ConfigureTaxAppTransfer::VENDOR_CODE => static::VENDOR_CODE,
            ConfigureTaxAppTransfer::IS_ACTIVE => true,
        ]);

        // Act
        $this->tester->handleTaxAppMessage($configureTaxAppTransfer);

        // Assert
        $this->tester->assertTaxAppConfigIsSavedCorrectlyForStore($storeTransfer, $configureTaxAppTransfer);
    }

    /**
     * @return void
     */
    public function testDeleteTaxAppMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);

        $this->createDummyTaxAppConfig();

        $deleteTaxAppTransfer = $this->tester->buildDeleteTaxAppTransfer([
            MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
        ], [
            DeleteTaxAppTransfer::VENDOR_CODE => static::VENDOR_CODE,
        ]);

        // Act
        $this->tester->handleTaxAppMessage($deleteTaxAppTransfer);

        // Assert
        $this->tester->assertTaxAppConfigIsRemovedForStore($storeTransfer, $deleteTaxAppTransfer);
    }

    /**
     * @return void
     */
    protected function createDummyTaxAppConfig(): void
    {
        $this->tester->handleTaxAppMessage(
            $this->tester->buildConfigureTaxAppTransfer([
                MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
                ConfigureTaxAppTransfer::VENDOR_CODE => static::VENDOR_CODE,
                ConfigureTaxAppTransfer::IS_ACTIVE => true,
            ]),
        );
    }
}
