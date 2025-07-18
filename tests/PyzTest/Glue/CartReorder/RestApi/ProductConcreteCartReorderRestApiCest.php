<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\CartReorder\RestApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\RestCheckoutErrorTransfer;
use PyzTest\Glue\CartReorder\CartReorderApiTester;
use PyzTest\Glue\CartReorder\RestApi\Fixtures\ProductConcreteCartReorderRestApiFixtures;
use Spryker\Glue\CartReorderRestApi\CartReorderRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group CartReorder
 * @group RestApi
 * @group ProductConcreteCartReorderRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductConcreteCartReorderRestApiCest
{
    /**
     * @var string
     */
    protected const RESPONSE_CODE_PARAMETER_ORDER_REFERENCE_INVALID = '901';

    /**
     * @var string
     */
    protected const RESPONSE_DETAIL_PARAMETER_ORDER_REFERENCE_INVALID = 'orderReference => This value should not be blank.';

    /**
     * @uses \Spryker\Glue\CartReorderRestApi\CartReorderRestApiConfig::ERROR_CODE_ORDER_NOT_FOUND
     *
     * @var string
     */
    protected const RESPONSE_CODE_ORDER_NOT_FOUND = '5801';

    /**
     * @uses \Spryker\Glue\CartReorderRestApi\CartReorderRestApiConfig::ERROR_CODE_QUOTE_NOT_PROVIDED
     *
     * @var string
     */
    protected const ERROR_CODE_QUOTE_NOT_PROVIDED = '5802';

    /**
     * @var string
     */
    protected const RESPONSE_DETAIL_ORDER_NOT_FOUND = 'Order not found.';

    /**
     * @var string
     */
    protected const RESPONSE_DETAIL_QUOTE_NOT_PROVIDED = 'Quote not provided.';

    /**
     * @uses \Spryker\Zed\PersistentCart\Communication\Plugin\CartReorder\ReplacePersistentCartReorderQuoteProviderStrategyPlugin::REORDER_STRATEGY_REPLACE
     *
     * @var string
     */
    protected const REORDER_STRATEGY_REPLACE = 'replace';

    /**
     * @var \PyzTest\Glue\CartReorder\RestApi\Fixtures\ProductConcreteCartReorderRestApiFixtures
     */
    protected ProductConcreteCartReorderRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function loadFixtures(CartReorderApiTester $I): void
    {
        /** @var \PyzTest\Glue\CartReorder\RestApi\Fixtures\ProductConcreteCartReorderRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(ProductConcreteCartReorderRestApiFixtures::class);

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

        $saveOrderTransfer = $this->fixtures->getOrderWithConcreteProducts();
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
        $this->assertCreateCartReorder($I);
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function requestCreateCartReorderWithReorderStrategyReplace(CartReorderApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $saveOrderTransfer = $this->fixtures->getOrderWithConcreteProducts();
        $requestPayload = [
            'data' => [
                'type' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
                'attributes' => [
                    'orderReference' => $saveOrderTransfer->getOrderReferenceOrFail(),
                    'reorderStrategy' => static::REORDER_STRATEGY_REPLACE,
                ],
            ],
        ];

        // Act
        $I->sendPost($I->getCartReorderUrl(), $requestPayload);

        // Assert
        $this->assertCreateCartReorder($I);
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function requestCreateCartReorderWithNotAvailableProduct(CartReorderApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $saveOrderTransfer = $this->fixtures->getOrderWithNotAvailableConcreteProduct();
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

        $I->amSure('The returned response includes first item.')
            ->whenI()
            ->assertResponseContainsItemBySku($this->fixtures->getProductConcreteTransfer1()->getSkuOrFail());
        $I->amSure('The first item has correct quantity.')
            ->whenI()
            ->assertItemHasCorrectQuantity($this->fixtures->getProductConcreteTransfer1()->getSkuOrFail(), 2);
        $I->amSure('The returned response does not include second item.')
            ->whenI()
            ->assertResponseDoesNotContainItemBySku($this->fixtures->getNotAvailableProductConcreteTransfer()->getSkuOrFail());
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function requestCreateReorderWithEmptyOrderReferenceParameter(CartReorderApiTester $I): void
    {
        //Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $requestPayload = [
            'data' => [
                'type' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
                'attributes' => [
                    'orderReference' => '',
                ],
            ],
        ];

        // Act
        $I->sendPost($I->getCartReorderUrl(), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $errors = $I->getDataFromResponseByJsonPath('$.errors[0]');
        $I->assertEquals($errors[RestCheckoutErrorTransfer::CODE], static::RESPONSE_CODE_PARAMETER_ORDER_REFERENCE_INVALID);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::STATUS], HttpCode::UNPROCESSABLE_ENTITY);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::DETAIL], static::RESPONSE_DETAIL_PARAMETER_ORDER_REFERENCE_INVALID);
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function requestCreateReorderWithNonExistingOrderReference(CartReorderApiTester $I): void
    {
        //Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $requestPayload = [
            'data' => [
                'type' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
                'attributes' => [
                    'orderReference' => 'non-existing-order-reference',
                ],
            ],
        ];

        // Act
        $I->sendPost($I->getCartReorderUrl(), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $errors = $I->getDataFromResponseByJsonPath('$.errors[0]');
        $I->assertEquals($errors[RestCheckoutErrorTransfer::CODE], static::RESPONSE_CODE_ORDER_NOT_FOUND);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::STATUS], HttpCode::UNPROCESSABLE_ENTITY);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::DETAIL], static::RESPONSE_DETAIL_ORDER_NOT_FOUND);
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function requestCreateReorderWithAnotherCustomersOrderReference(CartReorderApiTester $I): void
    {
        //Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $requestPayload = [
            'data' => [
                'type' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
                'attributes' => [
                    'orderReference' => $this->fixtures->getOrderFromAnotherCustomer()->getOrderReferenceOrFail(),
                ],
            ],
        ];

        // Act
        $I->sendPost($I->getCartReorderUrl(), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $errors = $I->getDataFromResponseByJsonPath('$.errors[0]');
        $I->assertEquals($errors[RestCheckoutErrorTransfer::CODE], static::RESPONSE_CODE_ORDER_NOT_FOUND);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::STATUS], HttpCode::UNPROCESSABLE_ENTITY);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::DETAIL], static::RESPONSE_DETAIL_ORDER_NOT_FOUND);
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    public function requestCreateReorderWithNonExistingReorderStrategy(CartReorderApiTester $I): void
    {
        //Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $saveOrderTransfer = $this->fixtures->getOrderWithConcreteProducts();
        $requestPayload = [
            'data' => [
                'type' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
                'attributes' => [
                    'orderReference' => $saveOrderTransfer->getOrderReferenceOrFail(),
                    'reorderStrategy' => 'non-existing-reorder-strategy',
                ],
            ],
        ];

        // Act
        $I->sendPost($I->getCartReorderUrl(), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $errors = $I->getDataFromResponseByJsonPath('$.errors[0]');
        $I->assertEquals($errors[RestCheckoutErrorTransfer::CODE], static::ERROR_CODE_QUOTE_NOT_PROVIDED);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::STATUS], HttpCode::UNPROCESSABLE_ENTITY);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::DETAIL], static::RESPONSE_DETAIL_QUOTE_NOT_PROVIDED);
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    protected function assertCreateCartReorder(CartReorderApiTester $I): void
    {
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource is of correct type.')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CartReorderApiTester::RESOURCE_CARTS);

        $I->amSure('The returned response includes first item.')
            ->whenI()
            ->assertResponseContainsItemBySku($this->fixtures->getProductConcreteTransfer1()->getSkuOrFail());
        $I->amSure('The first item has correct quantity.')
            ->whenI()
            ->assertItemHasCorrectQuantity($this->fixtures->getProductConcreteTransfer1()->getSkuOrFail(), 2);

        $I->amSure('The returned response includes second item.')
            ->whenI()
            ->assertResponseContainsItemBySku($this->fixtures->getProductConcreteTransfer2()->getSkuOrFail());
        $I->amSure('The second item has correct quantity.')
            ->whenI()
            ->assertItemHasCorrectQuantity($this->fixtures->getProductConcreteTransfer2()->getSkuOrFail(), 1);
    }

    /**
     * @param \PyzTest\Glue\CartReorder\CartReorderApiTester $I
     *
     * @return void
     */
    protected function deleteLastResponseCart(CartReorderApiTester $I): void
    {
        $I->sendDelete($I->buildCartsUrl($I->getDataFromResponseByJsonPath('$.data.id')));
    }
}
