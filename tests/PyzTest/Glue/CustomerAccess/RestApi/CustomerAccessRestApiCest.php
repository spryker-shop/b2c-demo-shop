<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\CustomerAccess\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\CustomerAccess\CustomerAccessApiTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group CustomerAccess
 * @group RestApi
 * @group CustomerAccessRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CustomerAccessRestApiCest
{
    /**
     * @param \PyzTest\Glue\CustomerAccess\CustomerAccessApiTester $I
     *
     * @return void
     */
    public function requestCustomerAccess(CustomerAccessApiTester $I): void
    {
        // Act
        $I->sendGET('customer-access');

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned collection of resources with type of type customer-access and size 1')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfTypeWithSizeOf('customer-access', 1);
    }
}
