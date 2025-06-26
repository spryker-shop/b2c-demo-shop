<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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
 * @group DeleteMethodRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class DeleteMethodRestApiCest
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
     * @param \PyzTest\Glue\Customer\CustomerApiTester $i
     *
     * When SymfonyListener is not enabled Glue returns 204 with content inside, this test is to check it doesn't happen
     * Jira ticket GLUE-9691
     *
     * @return void
     */
    public function ensureDeleteRequestHasNoBody(CustomerApiTester $i): void
    {
        // Arrange
        $customerTransfer = $i->haveCustomer(
            [
                CustomerTransfer::NEW_PASSWORD => 'change123',
                CustomerTransfer::PASSWORD => 'change123',
            ],
        );
        $i->confirmCustomer($customerTransfer);

        $oauthResponseTransfer = $i->haveAuthorizationToGlue($customerTransfer);

        $headers = [
            'Accept: */*',
            'Authorization: Bearer ' . $oauthResponseTransfer->getAccessToken(),
            'Cache-Control: no-cache',
            'Content-Type: application/json',
            'Store: DE',
        ];

        $url = $i->formatFullUrl(
            'customers/{CustomerReference}',
            ['CustomerReference' => $customerTransfer->getCustomerReference()],
        );

        // Act
        $result = file_get_contents(
            $url,
            false,
            stream_context_create(
                [
                    'http' => [
                        'method' => 'DELETE',
                        'header' => implode("\r\n", $headers),
                    ],
                ],
            ),
        );
        $responseCode = substr($http_response_header[0], 9, 3);

        // Assert
        $i->assertEquals(HttpCode::NO_CONTENT, $responseCode);
        $i->assertSame('', $result, 'Content in 204 response');
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $i
     *
     * @return void
     */
    public function ensureDeleteRequestForbidden(CustomerApiTester $i): void
    {
        // Arrange
        $customerTransfer = $i->haveCustomer(
            [
                CustomerTransfer::NEW_PASSWORD => 'change123',
                CustomerTransfer::PASSWORD => 'change123',
            ],
        );
        $i->confirmCustomer($customerTransfer);

        $oauthResponseTransfer = $i->haveAuthorizationToGlue($customerTransfer);

        $i->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $i->sendDelete(
            $i->formatUrl(
                '{resourceCustomers}/{customerReference}',
                [
                    'resourceCustomers' => CustomersRestApiConfig::RESOURCE_CUSTOMERS,
                    'customerReference' => 'wrongReference',
                ],
            ),
        );

        // Assert
        $i->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $i->seeResponseIsJson();
        $i->seeResponseMatchesOpenApiSchema();

        $i->seeResponseErrorsHaveCode(CustomersRestApiConfig::RESPONSE_CODE_CUSTOMER_UNAUTHORIZED);
        $i->seeResponseErrorsHaveStatus(HttpCode::FORBIDDEN);
        $i->seeResponseErrorsHaveDetail(CustomersRestApiConfig::RESPONSE_DETAILS_CUSTOMER_UNAUTHORIZED);
    }
}
