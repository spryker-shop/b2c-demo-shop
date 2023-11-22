<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Customer\RestApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerConfirmationAttributesTransfer;
use PyzTest\Glue\Customer\CustomerApiTester;
use Spryker\Glue\CustomersRestApi\CustomersRestApiConfig;
use Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig;
use Symfony\Component\HttpFoundation\Response;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Customer
 * @group RestApi
 * @group CustomerConfirmationCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CustomerConfirmationCest
{
    /**
     * @var \PyzTest\Glue\Customer\RestApi\CustomerRestApiFixtures
     */
    protected CustomerRestApiFixtures $fixtures;

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerTransfer;

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $I
     *
     * @return void
     */
    public function _before(CustomerApiTester $I): void
    {
        /** @var \PyzTest\Glue\Customer\RestApi\CustomerRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(CustomerRestApiFixtures::class);

        $this->fixtures = $fixtures;

        $this->customerTransfer = $I->haveCustomer(
            [
                CustomerTransfer::NEW_PASSWORD => 'change123',
                CustomerTransfer::PASSWORD => 'change123',
                CustomerTransfer::REGISTRATION_KEY => uniqid(),
            ],
        );
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $I
     *
     * @return void
     */
    public function requestPostCustomerConfirmationActivatesCustomerProfile(CustomerApiTester $I): void
    {
        // Arrange
        $restCustomerConfirmationAttributesTransfer = (new RestCustomerConfirmationAttributesTransfer())
            ->setRegistrationKey($this->customerTransfer->getRegistrationKey());

        // Act
        $I->sendPost(
            $I->formatUrl(CustomersRestApiConfig::RESOURCE_CUSTOMER_CONFIRMATION),
            [
                'data' => [
                    'type' => CustomersRestApiConfig::RESOURCE_CUSTOMER_CONFIRMATION,
                    'attributes' => $restCustomerConfirmationAttributesTransfer->modifiedToArray(true, true),
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $I
     *
     * @return void
     */
    public function requestPostCustomerConfirmationFailsOnUsedConfirmationCode(CustomerApiTester $I): void
    {
        // Arrange
        $confirmationCode = $this->customerTransfer->getRegistrationKey();
        $I->confirmCustomer($this->customerTransfer);

        $restCustomerConfirmationAttributesTransfer = (new RestCustomerConfirmationAttributesTransfer())
            ->setRegistrationKey($confirmationCode);

        // Act
        $I->sendPost(
            $I->formatUrl(CustomersRestApiConfig::RESOURCE_CUSTOMER_CONFIRMATION),
            [
                'data' => [
                    'type' => CustomersRestApiConfig::RESOURCE_CUSTOMER_CONFIRMATION,
                    'attributes' => $restCustomerConfirmationAttributesTransfer->modifiedToArray(true, true),
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(Response::HTTP_UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->seeResponseErrorsHaveCode(CustomersRestApiConfig::RESPONSE_CODE_CONFIRMATION_CODE_INVALID);
        $I->seeResponseErrorsHaveStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $I->seeResponseErrorsHaveDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CONFIRMATION_CODE_INVALID);
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $I
     *
     * @return void
     */
    public function requestPostCustomerConfirmationFailsOnEmptyConfirmationCode(CustomerApiTester $I): void
    {
        // Arrange
        $restCustomerConfirmationAttributesTransfer = (new RestCustomerConfirmationAttributesTransfer())
            ->setRegistrationKey('');

        // Act
        $I->sendPost(
            $I->formatUrl(CustomersRestApiConfig::RESOURCE_CUSTOMER_CONFIRMATION),
            [
                'data' => [
                    'type' => CustomersRestApiConfig::RESOURCE_CUSTOMER_CONFIRMATION,
                    'attributes' => $restCustomerConfirmationAttributesTransfer->modifiedToArray(true, true),
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(Response::HTTP_UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->seeResponseErrorsHaveCode(RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID);
        $I->seeResponseErrorsHaveStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $I->seeResponseErrorsHaveDetail('registrationKey => This value should not be blank.');
    }
}
