<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\OrderAmendments\RestApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\RestCheckoutErrorTransfer;
use PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester;
use PyzTest\Glue\OrderAmendments\RestApi\Fixtures\OrderAmendmentRestApiFixtures;
use Spryker\Glue\CartReorderRestApi\CartReorderRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group OrderAmendments
 * @group RestApi
 * @group OrderAmendmentsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class OrderAmendmentsRestApiCest
{
    /**
     * @var string
     */
    protected const RESPONSE_CODE_ORDER_IS_NOT_AMENDABLE = '5800';

    /**
     * @var string
     */
    protected const RESPONSE_DETAIL_ORDER_IS_NOT_AMENDABLE = 'The order cannot be amended.';

    /**
     * @var string
     */
    protected const RESPONSE_CODE_PARAMETER_IS_AMENDABLE_INVALID = '901';

    /**
     * @var string
     */
    protected const RESPONSE_DETAIL_PARAMETER_IS_AMENDABLE_INVALID = 'isAmendment => This value should be of type bool.';

    /**
     * @var \PyzTest\Glue\OrderAmendments\RestApi\Fixtures\OrderAmendmentRestApiFixtures
     */
    protected OrderAmendmentRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(OrderAmendmentsApiTester $I): void
    {
        /** @var \PyzTest\Glue\OrderAmendments\RestApi\Fixtures\OrderAmendmentRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(OrderAmendmentRestApiFixtures::class);
        $this->fixtures = $fixtures;
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return void
     */
    public function requestCreateOrderAmendmentWithInvalidOrder(OrderAmendmentsApiTester $I): void
    {
        //Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $requestPayload = [
            'data' => [
                'type' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
                'attributes' => [
                    'orderReference' => $this->fixtures->getNotReadyForAmendmentOrderTransfer()->getOrderReferenceOrFail(),
                    'isAmendment' => true,
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
        $I->assertEquals($errors[RestCheckoutErrorTransfer::CODE], static::RESPONSE_CODE_ORDER_IS_NOT_AMENDABLE);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::STATUS], HttpCode::UNPROCESSABLE_ENTITY);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::DETAIL], static::RESPONSE_DETAIL_ORDER_IS_NOT_AMENDABLE);
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return void
     */
    public function requestCreateOrderAmendmentWithEmptyIsAmendmentParameter(OrderAmendmentsApiTester $I): void
    {
        //Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $requestPayload = [
            'data' => [
                'type' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
                'attributes' => [
                    'orderReference' => $this->fixtures->getReadyForAmendmentOrderTransfer()->getOrderReferenceOrFail(),
                    'isAmendment' => '',
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
        $I->assertEquals($errors[RestCheckoutErrorTransfer::CODE], static::RESPONSE_CODE_PARAMETER_IS_AMENDABLE_INVALID);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::STATUS], HttpCode::UNPROCESSABLE_ENTITY);
        $I->assertEquals($errors[RestCheckoutErrorTransfer::DETAIL], static::RESPONSE_DETAIL_PARAMETER_IS_AMENDABLE_INVALID);
    }

    /**
     * @param \PyzTest\Glue\OrderAmendments\OrderAmendmentsApiTester $I
     *
     * @return void
     */
    public function requestCreateOrderAmendmentWithValidOrder(OrderAmendmentsApiTester $I): void
    {
        //Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

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
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource is of correct type')
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType('carts');

        $I->amSure('The returned response data contains amendment order reference')
            ->whenI()
            ->assertResponseContainsAmendmentOrderReference($this->fixtures->getReadyForAmendmentOrderTransfer()->getOrderReferenceOrFail());
    }
}
