<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Customer\RestApi;

use Codeception\Example;
use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerPasswordAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
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
 * @group CustomerPasswordCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CustomerPasswordCest
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
            ],
        );
        $I->confirmCustomer($this->customerTransfer);

        $oauthResponseTransfer = $I->haveAuthorizationToGlue($this->customerTransfer);
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $I
     *
     * @return void
     */
    public function requestPatchCustomerPasswordUpdatesCustomerPassword(CustomerApiTester $I): void
    {
        // Arrange
        $restCustomerPasswordAttributesTransfer = (new RestCustomerPasswordAttributesTransfer())
            ->setConfirmPassword('qwertyuI1!')
            ->setNewPassword('qwertyuI1!')
            ->setPassword('change123');

        // Act
        $I->sendPatch(
            $I->formatUrl(
                '{resourceCustomerPassword}/{customerReference}',
                [
                    'resourceCustomerPassword' => CustomersRestApiConfig::RESOURCE_CUSTOMER_PASSWORD,
                    'customerReference' => $this->customerTransfer->getCustomerReference(),
                ],
            ),
            [
                'data' => [
                    'type' => CustomersRestApiConfig::RESOURCE_CUSTOMER_PASSWORD,
                    'id' => $this->customerTransfer->getCustomerReference(),
                    'attributes' => $restCustomerPasswordAttributesTransfer->modifiedToArray(true, true),
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
    public function requestPatchCustomerPasswordFailsToUseAnotherCustomerReference(CustomerApiTester $I): void
    {
        // Arrange
        $firstCustomerTransfer = $I->haveCustomer(
            [
                CustomerTransfer::NEW_PASSWORD => 'change123',
                CustomerTransfer::PASSWORD => 'change123',
            ],
        );
        $I->confirmCustomer($firstCustomerTransfer);

        $restCustomerPasswordAttributesTransfer = (new RestCustomerPasswordAttributesTransfer())
            ->setConfirmPassword('qwertyuI1!')
            ->setNewPassword('qwertyuI1!')
            ->setPassword('change123');

        // Act
        $I->sendPatch(
            $I->formatUrl(
                '{resourceCustomerPassword}/{customerReference}',
                [
                    'resourceCustomerPassword' => CustomersRestApiConfig::RESOURCE_CUSTOMER_PASSWORD,
                    'customerReference' => $firstCustomerTransfer->getCustomerReference(),
                ],
            ),
            [
                'data' => [
                    'type' => CustomersRestApiConfig::RESOURCE_CUSTOMER_PASSWORD,
                    'id' => $firstCustomerTransfer->getCustomerReference(),
                    'attributes' => $restCustomerPasswordAttributesTransfer->modifiedToArray(true, true),
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(Response::HTTP_FORBIDDEN);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->seeResponseErrorsHaveCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_UNAUTHORIZED);
        $I->seeResponseErrorsHaveStatus(Response::HTTP_FORBIDDEN);
        $I->seeResponseErrorsHaveDetail(CustomersRestApiConfig::RESPONSE_DETAILS_CUSTOMER_UNAUTHORIZED);
    }

    /**
     * @dataProvider requestPatchCustomerPasswordFailsValidationDataProvider
     *
     * @param \PyzTest\Glue\Customer\CustomerApiTester $I
     * @param \Codeception\Example $example
     *
     * @return void
     */
    public function requestPatchCustomerPasswordFailsValidation(CustomerApiTester $I, Example $example): void
    {
        // Act
        $I->sendPatch(
            $I->formatUrl(
                '{resourceCustomerPassword}/{customerReference}',
                [
                    'resourceCustomerPassword' => CustomersRestApiConfig::RESOURCE_CUSTOMER_PASSWORD,
                    'customerReference' => $this->customerTransfer->getCustomerReference(),
                ],
            ),
            [
                'data' => [
                    'type' => CustomersRestApiConfig::RESOURCE_CUSTOMER_PASSWORD,
                    'id' => $this->customerTransfer->getCustomerReference(),
                    'attributes' => $example['attributes'],
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs($example[RestErrorMessageTransfer::STATUS]);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        foreach ($example['errors'] as $index => $error) {
            $I->seeResponseErrorsHaveCode($error[RestErrorMessageTransfer::CODE], $index);
            $I->seeResponseErrorsHaveStatus($error[RestErrorMessageTransfer::STATUS], $index);
            $I->seeResponseErrorsHaveDetail($error[RestErrorMessageTransfer::DETAIL], $index);
        }
    }

    /**
     * @return array
     */
    protected function requestPatchCustomerPasswordFailsValidationDataProvider(): array
    {
        return [
            [
                'attributes' => [
                    RestCustomerPasswordAttributesTransfer::PASSWORD => 'change123',
                    RestCustomerPasswordAttributesTransfer::NEW_PASSWORD => 'qwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiop',
                    RestCustomerPasswordAttributesTransfer::CONFIRM_PASSWORD => 'qwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiop',
                ],
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'newPassword => This value is too long. It should have 64 characters or less.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'confirmPassword => This value is too long. It should have 64 characters or less.',
                    ],
                ],
            ],
            [
                'attributes' => [
                    RestCustomerPasswordAttributesTransfer::PASSWORD => 'change123',
                    RestCustomerPasswordAttributesTransfer::NEW_PASSWORD => 'qwe',
                    RestCustomerPasswordAttributesTransfer::CONFIRM_PASSWORD => 'qwe',
                ],
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'newPassword => This value is too short. It should have 8 characters or more.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'confirmPassword => This value is too short. It should have 8 characters or more.',
                    ],
                ],
            ],
            [
                'attributes' => [
                    RestCustomerPasswordAttributesTransfer::PASSWORD => 'change123',
                    RestCustomerPasswordAttributesTransfer::NEW_PASSWORD => 'qwertyui',
                    RestCustomerPasswordAttributesTransfer::CONFIRM_PASSWORD => 'qwertyui',
                ],
                RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_PASSWORD_INVALID_CHARACTER_SET,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                        RestErrorMessageTransfer::DETAIL => CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_PASSWORD_INVALID_CHARACTER_SET,
                    ],
                ],
            ],
            [
                'attributes' => [
                    RestCustomerPasswordAttributesTransfer::PASSWORD => 'change123',
                    RestCustomerPasswordAttributesTransfer::NEW_PASSWORD => 'qwertyuI1!eee',
                    RestCustomerPasswordAttributesTransfer::CONFIRM_PASSWORD => 'qwertyuI1!eee',
                ],
                RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_PASSWORD_SEQUENCE_NOT_ALLOWED,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                        RestErrorMessageTransfer::DETAIL => CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_PASSWORD_SEQUENCE_NOT_ALLOWED,
                    ],
                ],
            ],
        ];
    }
}
