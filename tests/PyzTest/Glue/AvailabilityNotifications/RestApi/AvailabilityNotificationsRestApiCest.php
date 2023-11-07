<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\AvailabilityNotifications\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\AvailabilityNotifications\AvailabilityNotificationsRestApiTester;
use PyzTest\Glue\AvailabilityNotifications\RestApi\Fixtures\AvailabilityNotificationsApiFixtures;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group AvailabilityNotifications
 * @group RestApi
 * @group AvailabilityNotificationsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class AvailabilityNotificationsRestApiCest
{
    /**
     * @var \PyzTest\Glue\AvailabilityNotifications\RestApi\Fixtures\AvailabilityNotificationsApiFixtures
     */
    protected AvailabilityNotificationsApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\AvailabilityNotifications\AvailabilityNotificationsRestApiTester.php $I
     *
     * @return void
     */
    public function loadFixtures(AvailabilityNotificationsRestApiTester $I): void
    {
        /** @var \PyzTest\Glue\AvailabilityNotifications\RestApi\Fixtures\AvailabilityNotificationsApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(AvailabilityNotificationsApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @param \PyzTest\Glue\AvailabilityNotifications\AvailabilityNotificationsRestApiTester $I
     *
     * @return void
     */
    public function requestCustomerAvailabilityNotifications(AvailabilityNotificationsRestApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();

        $url = $I->buildCustomerAvailabilityNotificationsUrl($customerTransfer->getCustomerReference());

        $oauthResponseTransfer = $I->haveAuthorizationToGlue($customerTransfer);
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @param \PyzTest\Glue\AvailabilityNotifications\AvailabilityNotificationsRestApiTester $I
     *
     * @return void
     */
    public function requestCustomerAvailabilityNotificationsAuthorizationError(AvailabilityNotificationsRestApiTester $I): void
    {
        // Arrange
        $customerTransfer = $this->fixtures->getCustomerTransfer();

        $url = $I->buildCustomerAvailabilityNotificationsUrl('wrongCustomerReference');

        $oauthResponseTransfer = $I->haveAuthorizationToGlue($customerTransfer);
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }
}
