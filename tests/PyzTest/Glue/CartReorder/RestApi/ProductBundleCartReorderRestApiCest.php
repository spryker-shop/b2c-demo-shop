<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\CartReorder\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\CartReorder\CartReorderApiTester;
use PyzTest\Glue\CartReorder\RestApi\Fixtures\ProductBundleCartReorderRestApiFixtures;
use Spryker\Glue\CartReorderRestApi\CartReorderRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group CartReorder
 * @group RestApi
 * @group ProductBundleCartReorderRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductBundleCartReorderRestApiCest
{
    /**
     * @var \PyzTest\Glue\CartReorder\RestApi\Fixtures\ProductBundleCartReorderRestApiFixtures
     */
    protected ProductBundleCartReorderRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CartReorderApiTester $I): void
    {
        /** @var \PyzTest\Glue\CartReorder\RestApi\Fixtures\ProductBundleCartReorderRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(ProductBundleCartReorderRestApiFixtures::class);

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

        $saveOrderTransfer = $this->fixtures->getOrderWithProductBundle();
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

        $I->amSure('The returned response includes bundle item.')
            ->whenI()
            ->assertResponseContainsBundleItemBySku($this->fixtures->getProductBundleTransfer()->getSkuOrFail());
        $I->amSure('The bundle item has correct quantity.')
            ->whenI()
            ->assertBundleItemHasCorrectQuantity(
                $this->fixtures->getProductBundleTransfer()->getSkuOrFail(),
                2,
            );
    }
}
