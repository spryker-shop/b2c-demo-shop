<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Customer\RestApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\CustomerTransfer;
use PyzTest\Glue\Customer\CustomerApiTester;
use Spryker\Glue\CustomersRestApi\CustomersRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Customer
 * @group RestApi
 * @group CustomerReadCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CustomerReadCest
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
    public function requestGetCustomerReturnsCollectionWithOneResource(CustomerApiTester $I): void
    {
        // Act
        $I->sendGet(CustomersRestApiConfig::RESOURCE_CUSTOMERS);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->seeResourceByIdHasSelfLink(
            $this->customerTransfer->getCustomerReference(),
            $I->formatFullUrl(
                '{resourceCustomers}/{customerReference}',
                [
                    'resourceCustomers' => CustomersRestApiConfig::RESOURCE_CUSTOMERS,
                    'customerReference' => $this->customerTransfer->getCustomerReference(),
                ],
            ),
        );

        $I->amSure(sprintf('Returned resource is of type %s', CustomersRestApiConfig::RESOURCE_CUSTOMERS))
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfType(CustomersRestApiConfig::RESOURCE_CUSTOMERS);

        $I->amSure(sprintf('Returned resource has id %s', CustomersRestApiConfig::RESOURCE_CUSTOMERS))
            ->whenI()
            ->seeResourceCollectionHasResourceWithId($this->customerTransfer->getCustomerReference());

        $I->amSure('Returned resource correct attributes')
            ->whenI()
            ->assertCustomersAttributes(
                $this->customerTransfer,
                $I->getDataFromResponseByJsonPath('$.data[0].attributes'),
            );
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $I
     *
     * @return void
     */
    public function requestGetCustomerByIdReturnsOneResource(CustomerApiTester $I): void
    {
        // Act
        $I->sendGet(
            $I->formatUrl(
                '{resourceCustomers}/{customerReference}',
                [
                    'resourceCustomers' => CustomersRestApiConfig::RESOURCE_CUSTOMERS,
                    'customerReference' => $this->customerTransfer->getCustomerReference(),
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->seeSingleResourceHasSelfLink(
            $I->formatFullUrl(
                '{resourceCustomers}/{customerReference}',
                [
                    'resourceCustomers' => CustomersRestApiConfig::RESOURCE_CUSTOMERS,
                    'customerReference' => $this->customerTransfer->getCustomerReference(),
                ],
            ),
        );

        $I->amSure(sprintf('Returned resource is of type %s', CustomersRestApiConfig::RESOURCE_CUSTOMERS))
            ->whenI()
            ->seeResponseDataContainsSingleResourceOfType(CustomersRestApiConfig::RESOURCE_CUSTOMERS);

        $I->amSure(sprintf('Returned resource has id %s', CustomersRestApiConfig::RESOURCE_CUSTOMERS))
            ->whenI()
            ->seeSingleResourceIdEqualTo($this->customerTransfer->getCustomerReference());

        $I->amSure('Returned resource correct attributes')
            ->whenI()
            ->assertCustomersAttributes(
                $this->customerTransfer,
                $I->getDataFromResponseByJsonPath('$.data.attributes'),
            );
    }
}
