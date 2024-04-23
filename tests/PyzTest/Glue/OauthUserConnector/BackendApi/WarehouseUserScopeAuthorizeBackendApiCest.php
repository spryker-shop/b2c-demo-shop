<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\OauthUserConnector\BackendApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\OauthUserConnector\BackendApi\Fixtures\OauthUserConnectorBackendApiFixtures;
use PyzTest\Glue\OauthUserConnector\OauthUserConnectorBackendApiTester;
use Spryker\Glue\WarehouseUsersBackendApi\WarehouseUsersBackendApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group OauthUserConnector
 * @group BackendApi
 * @group WarehouseUserScopeAuthorizeBackendApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class WarehouseUserScopeAuthorizeBackendApiCest
{
    /**
     * @var \PyzTest\Glue\OauthUserConnector\BackendApi\Fixtures\OauthUserConnectorBackendApiFixtures
     */
    protected OauthUserConnectorBackendApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\OauthUserConnector\OauthUserConnectorBackendApiTester $I
     *
     * @return void
     */
    public function loadFixtures(OauthUserConnectorBackendApiTester $I): void
    {
        /** @var \PyzTest\Glue\OauthUserConnector\BackendApi\Fixtures\OauthUserConnectorBackendApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(OauthUserConnectorBackendApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\OauthUserConnector\OauthUserConnectorBackendApiTester $I
     *
     * @return void
     */
    public function requestWarehouseUserAssignmentsForWarehouseUserAllowed(OauthUserConnectorBackendApiTester $I): void
    {
        $backendOauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($backendOauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiGet(WarehouseUsersBackendApiConfig::RESOURCE_TYPE_WAREHOUSE_USER_ASSIGNMENTS);

        //Assert
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
