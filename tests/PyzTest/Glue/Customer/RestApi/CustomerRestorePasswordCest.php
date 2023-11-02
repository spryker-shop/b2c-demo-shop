<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Customer\RestApi;

use Codeception\Example;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomerRestorePasswordAttributesTransfer;
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
 * @group CustomerRestorePasswordCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CustomerRestorePasswordCest
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
                CustomerTransfer::RESTORE_PASSWORD_KEY => uniqid(),
            ],
        );
        $I->confirmCustomer($this->customerTransfer);
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
        // Arrange
        $attributes = array_merge(
            $example['attributes'],
            [
                RestCustomerRestorePasswordAttributesTransfer::RESTORE_PASSWORD_KEY => $this->customerTransfer->getRestorePasswordKey(),
            ],
        );

        // Act
        $I->sendPatch(
            $I->formatUrl(
                '{resourceCustomerPasswordRestore}/1',
                [
                    'resourceCustomerPasswordRestore' => CustomersRestApiConfig::RESOURCE_CUSTOMER_RESTORE_PASSWORD,
                ],
            ),
            [
                'data' => [
                    'type' => CustomersRestApiConfig::RESOURCE_CUSTOMER_RESTORE_PASSWORD,
                    'id' => '1',
                    'attributes' => $attributes,
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
                    RestCustomerRestorePasswordAttributesTransfer::PASSWORD => 'qwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiop',
                    RestCustomerRestorePasswordAttributesTransfer::CONFIRM_PASSWORD => 'qwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiopqwertyuiop',
                ],
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
                'attributes' => [
                    RestCustomerRestorePasswordAttributesTransfer::PASSWORD => 'qwe',
                    RestCustomerRestorePasswordAttributesTransfer::CONFIRM_PASSWORD => 'qwe',
                ],
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
        ];
    }
}
