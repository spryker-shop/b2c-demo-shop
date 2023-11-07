<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Customer\RestApi;

use Codeception\Example;
use Generated\Shared\DataBuilder\RestCustomersAttributesBuilder;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomersAttributesTransfer;
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
 * @group CustomerRegistrationCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CustomerRegistrationCest
{
    /**
     * @var \PyzTest\Glue\Customer\RestApi\CustomerRestApiFixtures
     */
    protected CustomerRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $i
     *
     * @return void
     */
    public function _before(CustomerApiTester $i): void
    {
        /** @var \PyzTest\Glue\Customer\RestApi\CustomerRestApiFixtures $fixtures */
        $fixtures = $i->loadFixtures(CustomerRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $I
     *
     * @return void
     */
    public function requestPostCustomerFailsOnExistingEmailUsage(CustomerApiTester $I): void
    {
        // Arrange
        /** @var \Generated\Shared\Transfer\RestCustomersAttributesTransfer $restCustomersAttributesTransfer */
        $restCustomersAttributesTransfer = (new RestCustomersAttributesBuilder([
            RestCustomersAttributesTransfer::PASSWORD => 'change123',
            RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'change123',
            RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
        ]))->build();
        $customerTransfer = $I->haveCustomer(
            [
                CustomerTransfer::NEW_PASSWORD => 'change123',
                CustomerTransfer::PASSWORD => 'change123',
            ],
        );
        $I->confirmCustomer($customerTransfer);

        $restCustomersAttributesTransfer->setEmail($customerTransfer->getEmail());

        // Act
        $I->sendPOST(
            CustomersRestApiConfig::RESOURCE_CUSTOMERS,
            [
                'data' => [
                    'type' => CustomersRestApiConfig::RESOURCE_CUSTOMERS,
                    'attributes' => $restCustomersAttributesTransfer->toArray(true, true),
                ],
            ],
        );

        // Assert
        $I->seeResponseCodeIs(Response::HTTP_UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->seeResponseErrorsHaveCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_ALREADY_EXISTS);
        $I->seeResponseErrorsHaveStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $I->seeResponseErrorsHaveDetail(CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_ALREADY_EXISTS);
    }

    /**
     * @dataProvider requestPostCustomerFailsValidationDataProvider
     *
     * @param \PyzTest\Glue\Customer\CustomerApiTester $I
     * @param \Codeception\Example $example
     *
     * @return void
     */
    public function requestPostCustomerFailsValidation(CustomerApiTester $I, Example $example): void
    {
        // Act
        $I->sendPOST(
            CustomersRestApiConfig::RESOURCE_CUSTOMERS,
            [
                'data' => [
                    'type' => CustomersRestApiConfig::RESOURCE_CUSTOMERS,
                    'attributes' => $example['attributes']->toArray(true, true),
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
    protected function requestPostCustomerFailsValidationDataProvider(): array
    {
        return [
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => false,
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'acceptedTerms => This value should be true.',
                    ],
                ],
            ],
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
                    RestCustomersAttributesTransfer::SALUTATION => 'xyz',
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'salutation => The value you selected is not a valid choice.',
                    ],
                ],
            ],
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'change123',
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => CustomersRestApiConfig::RESPONSE_CODE_NOT_ACCEPTED_TERMS,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                        RestErrorMessageTransfer::DETAIL => CustomersRestApiConfig::RESPONSE_DETAILS_NOT_ACCEPTED_TERMS,
                    ],
                ],
            ],
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'change1234',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => CustomersRestApiConfig::RESPONSE_CODE_PASSWORDS_DONT_MATCH,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => sprintf(
                            CustomersRestApiConfig::RESPONSE_DETAILS_PASSWORDS_DONT_MATCH,
                            RestCustomersAttributesTransfer::PASSWORD,
                            RestCustomersAttributesTransfer::CONFIRM_PASSWORD,
                        ),
                    ],
                ],
            ],
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'password => This value should not be blank.',
                    ],
                ],
            ],
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'confirmPassword => This value should not be blank.',
                    ],
                ],
            ],
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'qwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiop',
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'qwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiop',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'password => This value is too long. It should have 64 characters or less.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'confirmPassword => This value is too long. It should have 64 characters or less.',
                    ],
                ],
            ],
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'qwe',
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'qwe',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'password => This value is too short. It should have 8 characters or more.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'confirmPassword => This value is too short. It should have 8 characters or more.',
                    ],
                ],
            ],
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'qwertyui',
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'qwertyui',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
                ]))->build(),
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
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'qwertyuI1!eee',
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'qwertyuI1!eee',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_PASSWORD_SEQUENCE_NOT_ALLOWED,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_BAD_REQUEST,
                        RestErrorMessageTransfer::DETAIL => CustomersRestApiConfig::RESPONSE_MESSAGE_CUSTOMER_PASSWORD_SEQUENCE_NOT_ALLOWED,
                    ],
                ],
            ],
            [
                'attributes' => (new RestCustomersAttributesBuilder([
                    RestCustomersAttributesTransfer::PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::CONFIRM_PASSWORD => 'change123',
                    RestCustomersAttributesTransfer::ACCEPTED_TERMS => true,
                    RestCustomersAttributesTransfer::GENDER => 'xyz',
                ]))->build(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'gender => The value you selected is not a valid choice.',
                    ],
                ],
            ],
            [
                'attributes' => new RestCustomersAttributesTransfer(),
                RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'email => This value should not be blank.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'gender => This value should not be blank.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'salutation => This value should not be blank.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'firstName => This value should not be blank.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'lastName => This value should not be blank.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'password => This value should not be blank.',
                    ],
                    [
                        RestErrorMessageTransfer::CODE => RestRequestValidatorConfig::RESPONSE_CODE_REQUEST_INVALID,
                        RestErrorMessageTransfer::STATUS => Response::HTTP_UNPROCESSABLE_ENTITY,
                        RestErrorMessageTransfer::DETAIL => 'confirmPassword => This value should not be blank.',
                    ],
                ],
            ],
        ];
    }
}
