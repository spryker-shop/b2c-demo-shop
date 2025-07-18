<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\CartReorder\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\CartReorder\CartReorderApiTester;
use PyzTest\Glue\CartReorder\RestApi\Fixtures\ProductOptionsCartReorderRestApiFixtures;
use Spryker\Glue\CartReorderRestApi\CartReorderRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group CartReorder
 * @group RestApi
 * @group ProductOptionsCartReorderRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductOptionsCartReorderRestApiCest
{
    /**
     * @var \PyzTest\Glue\CartReorder\RestApi\Fixtures\ProductOptionsCartReorderRestApiFixtures
     */
    protected ProductOptionsCartReorderRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CartReorderApiTester $I): void
    {
        /** @var \PyzTest\Glue\CartReorder\RestApi\Fixtures\ProductOptionsCartReorderRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(ProductOptionsCartReorderRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function requestCreateCartReorder(CartReorderApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $saveOrderTransfer = $this->fixtures->getOrderWithProductOptions();
        $requestPayload = [
            'data' => [
                'type' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
                'attributes' => [
                    'orderReference' => $saveOrderTransfer->getOrderReferenceOrFail(),
                ],
            ],
        ];

        // Act
        $I->sendPost($I->getCartReorderUrl(), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource is of correct type.')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartReorderApiTester::RESOURCE_CARTS);

        $I->amSure('The returned response includes first item.')
            ->whenI()
            ->assertResponseContainsItemBySku($this->fixtures->getProductConcreteTransfer()->getSkuOrFail());
        $I->amSure('The first item has correct quantity.')
            ->whenI()
            ->assertItemHasCorrectQuantity($this->fixtures->getProductConcreteTransfer()->getSkuOrFail(), 1);

        $I->amSure('The returned response includes second item.')
            ->whenI()
            ->assertResponseContainsItemBySku($this->fixtures->getProductConcreteTransferWithProductOptions()->getSkuOrFail());
        $I->amSure('The second item has correct quantity.')
            ->whenI()
            ->assertItemHasCorrectQuantity(
                $this->fixtures->getProductConcreteTransferWithProductOptions()->getSkuOrFail(),
                2,
            );
        $I->amSure('The second item has correct product option.')
            ->whenI()
            ->assertItemHasProductOption(
                $this->fixtures->getProductConcreteTransferWithProductOptions()->getSkuOrFail(),
                $this->fixtures->getProductOptionTransfer()->getSkuOrFail(),
            );
    }
}
