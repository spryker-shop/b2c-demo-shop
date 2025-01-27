<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\TaxApp\Communication;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\MessageAttributesTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use PyzTest\Zed\TaxApp\TaxAppTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
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
    protected const STORE_REFERENCE = 'dev-DE';

    /**
     * @var string
     */
    protected const TENANT_IDENTIFIER = 'dev-DE';

    /**
     * @var \PyzTest\Zed\TaxApp\TaxAppTester
     */
    protected TaxAppTester $tester;

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
            MessageAttributesTransfer::TENANT_IDENTIFIER => static::TENANT_IDENTIFIER,
            MessageAttributesTransfer::EMITTER => 'test',
        ]);

        // Act
        $this->tester->handleTaxAppMessage($configureTaxAppTransfer);

        // Assert
        $this->tester->assertTaxAppConfigExistsForStore($storeTransfer);
    }

    /**
     * @return void
     */
    protected function testDeleteTaxAppMessageIsSuccessfullyHandled(): void
    {
        // Arrange
        $storeTransfer = $this->tester->getAllowedStore();
        $this->tester->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);

        $emitter = 'test';
        $this->createDummyTaxAppConfig($storeTransfer, $emitter);

        $deleteTaxAppTransfer = $this->tester->buildDeleteTaxAppTransfer([
            MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
            MessageAttributesTransfer::TENANT_IDENTIFIER => static::TENANT_IDENTIFIER,
            MessageAttributesTransfer::EMITTER => $emitter,
        ]);

        // Act
        $this->tester->handleTaxAppMessage($deleteTaxAppTransfer);

        // Assert
        $this->tester->assertTaxAppConfigIsRemovedForStore($storeTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     * @param string $emitter
     *
     * @return void
     */
    protected function createDummyTaxAppConfig(StoreTransfer $storeTransfer, string $emitter): void
    {
        $this->tester->removeTaxAppConfigForStore($storeTransfer);
        $this->tester->handleTaxAppMessage(
            $this->tester->buildConfigureTaxAppTransfer([
                MessageAttributesTransfer::STORE_REFERENCE => static::STORE_REFERENCE,
                MessageAttributesTransfer::TENANT_IDENTIFIER => static::TENANT_IDENTIFIER,
                MessageAttributesTransfer::EMITTER => $emitter,
            ]),
        );
    }
}
