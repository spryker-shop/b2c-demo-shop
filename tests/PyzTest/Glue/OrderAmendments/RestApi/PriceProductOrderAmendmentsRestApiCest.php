<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\OrderAmendments\RestApi;

use PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester;
use PyzTest\Glue\OrderAmendments\RestApi\Fixtures\PriceProductOrderAmendmentRestApiFixtures;
use Spryker\Glue\CartReorderRestApi\CartReorderRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group OrderAmendments
 * @group RestApi
 * @group PriceProductOrderAmendmentsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class PriceProductOrderAmendmentsRestApiCest
{
    /**
     * @var \PyzTest\Glue\OrderAmendments\RestApi\Fixtures\PriceProductOrderAmendmentRestApiFixtures
     */
    protected PriceProductOrderAmendmentRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(OrderAmendmentsApiTester $I): void
    {
        /** @var \PyzTest\Glue\OrderAmendments\RestApi\Fixtures\PriceProductOrderAmendmentRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(PriceProductOrderAmendmentRestApiFixtures::class);
        $this->fixtures = $fixtures;
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return void
     */
    public function requestCreateOrderAmendmentWithPricesSavedFromTheOrder(OrderAmendmentsApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $this->assertProductPricesBeforeOrderAmendment($I);

        $requestPayload = [
            'data' => [
                'type' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
                'attributes' => [
                    'orderReference' => $this->fixtures->getReadyForAmendmentOrderTransfer()->getOrderReferenceOrFail(),
                    'isAmendment' => true,
                ],
            ],
        ];

        // Act
        $I->sendPost($I->getCartReorderUrl(), $requestPayload);

        // Assert
        $I->assertSame(
            PriceProductOrderAmendmentRestApiFixtures::DEFAULT_UNIT_PRICE_AMOUNT,
            $I->grabDataFromResponseByJsonPath('$.included[?(@.attributes.sku=="' . $this->fixtures->getProductWithBiggerPrice()->getSku() . '")].attributes.calculations.unitPrice')[0],
        );

        $I->assertSame(
            PriceProductOrderAmendmentRestApiFixtures::LOWER_UNIT_PRICE_AMOUNT,
            $I->grabDataFromResponseByJsonPath('$.included[?(@.attributes.sku=="' . $this->fixtures->getProductWithLowerPrice()->getSku() . '")].attributes.calculations.unitPrice')[0],
        );
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return void
     */
    protected function assertProductPricesBeforeOrderAmendment(OrderAmendmentsApiTester $I): void
    {
        $I->sendGET($I->getConcreteProductPricesUrl($this->fixtures->getProductWithBiggerPrice()->getSku()));

        $I->assertSame(
            PriceProductOrderAmendmentRestApiFixtures::BIGGER_UNIT_PRICE_AMOUNT,
            $I->getDataFromResponseByJsonPath('$.data[0].attributes.prices[0].grossAmount'),
        );

        $I->sendGET($I->getConcreteProductPricesUrl($this->fixtures->getProductWithLowerPrice()->getSku()));

        $I->assertSame(
            PriceProductOrderAmendmentRestApiFixtures::LOWER_UNIT_PRICE_AMOUNT,
            $I->getDataFromResponseByJsonPath('$.data[0].attributes.prices[0].grossAmount'),
        );
    }
}
