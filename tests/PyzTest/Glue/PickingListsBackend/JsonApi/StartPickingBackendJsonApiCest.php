<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\PickingListsBackend\JsonApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\PickingListTransfer;
use PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\StartPickingBackendJsonApiFixtures;
use PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester;
use Spryker\Glue\PickingListsBackendApi\PickingListsBackendApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group PickingListsBackend
 * @group JsonApi
 * @group StartPickingBackendJsonApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class StartPickingBackendJsonApiCest
{
    /**
     * @uses \Spryker\Shared\PickingList\PickingListConfig::STATUS_READY_FOR_PICKING
     *
     * @var string
     */
    protected const STATUS_READY_FOR_PICKING = 'ready-for-picking';

    /**
     * @uses \Spryker\Shared\PickingList\PickingListConfig::STATUS_READY_FOR_PICKING
     *
     * @var string
     */
    protected const STATUS_PICKING_STARTED = 'picking-started';

    /**
     * @uses \Spryker\Shared\PickingList\PickingListConfig::STATUS_PICKING_FINISHED
     *
     * @var string
     */
    protected const STATUS_PICKING_FINISHED = 'picking-finished';

    /**
     * @uses \Spryker\Glue\PickingListsBackendApi\PickingListsBackendApiConfig::RESPONSE_CODE_PICKED_BY_ANOTHER_USER
     *
     * @var string
     */
    protected const RESPONSE_CODE_PICKED_BY_ANOTHER_USER = '5310';

    /**
     * @var string
     */
    protected const ERROR_DETAIL_PICKED_BY_ANOTHER_USER = 'Picklist is already being picked by another user.';

    /**
     * @var \PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\StartPickingBackendJsonApiFixtures
     */
    protected StartPickingBackendJsonApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function loadFixtures(PickingListsBackendApiTester $I): void
    {
        /** @var \PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\StartPickingBackendJsonApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(StartPickingBackendJsonApiFixtures::class);
        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestAssignsWarehouseUserToPickingList(PickingListsBackendApiTester $I): void
    {
        // Arrange
        $pickingListTransfer = $this->fixtures->getReadyForPickingPickingListTransfer();
        $userTransfer = $this->fixtures->getMainWarehouseUserTransfer();

        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($userTransfer);
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getStartPickingUrl($pickingListTransfer);

        // Act
        $I->sendJsonApiPost($url, []);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->amSure('The returned resource contains single picking lists resource')
            ->whenI()
            ->seeJsonApiResponseDataContainsSingleResourceOfType(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
            );
        $I->amSure('The returned resource has correct ID')
            ->whenI()
            ->seeJsonApiSingleResourceIdEqualTo($pickingListTransfer->getUuidOrFail());
        $I->amSure('The returned picking list has correct status')
            ->whenI()
            ->seePickingListHaveCorrectStatus(static::STATUS_PICKING_STARTED);
        $I->amSure('User is assigned to picking list')
            ->whenI()
            ->seeUserIsAssignedToPickingList($pickingListTransfer, $userTransfer);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsPickingListResponseWhenWarehouseUserAlreadyAssignedToPickingListWithPickingStartedStatus(
        PickingListsBackendApiTester $I,
    ): void {
        // Arrange
        $pickingListTransfer = $this->fixtures->getPickingStartedPickingListTransfer();
        $userTransfer = $this->fixtures->getMainWarehouseUserTransfer();

        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($userTransfer);
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getStartPickingUrl($pickingListTransfer);

        // Act
        $I->sendJsonApiPost($url);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->amSure('The returned resource contains single picking lists resource')
            ->whenI()
            ->seeJsonApiResponseDataContainsSingleResourceOfType(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
            );
        $I->amSure('The returned resource has correct ID')
            ->whenI()
            ->seeJsonApiSingleResourceIdEqualTo($pickingListTransfer->getUuidOrFail());
        $I->amSure('The returned picking list has correct status')
            ->whenI()
            ->seePickingListHaveCorrectStatus(static::STATUS_PICKING_STARTED);
        $I->amSure('User is assigned to picking list')
            ->whenI()
            ->seeUserIsAssignedToPickingList($pickingListTransfer, $userTransfer);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsPickingListResponseWhenWarehouseUserAlreadyAssignedToPickingListWithPickingFinishedStatus(
        PickingListsBackendApiTester $I,
    ): void {
        // Arrange
        $pickingListTransfer = $this->fixtures->getPickingFinishedPickingListTransfer();
        $userTransfer = $this->fixtures->getMainWarehouseUserTransfer();

        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($userTransfer);
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getStartPickingUrl($pickingListTransfer);

        // Act
        $I->sendJsonApiPost($url);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->amSure('The returned resource contains single picking lists resource')
            ->whenI()
            ->seeJsonApiResponseDataContainsSingleResourceOfType(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
            );
        $I->amSure('The returned resource has correct ID')
            ->whenI()
            ->seeJsonApiSingleResourceIdEqualTo($pickingListTransfer->getUuidOrFail());
        $I->amSure('The returned picking list has correct status')
            ->whenI()
            ->seePickingListHaveCorrectStatus(static::STATUS_PICKING_FINISHED);
        $I->amSure('User is assigned to picking list')
            ->whenI()
            ->seeUserIsAssignedToPickingList($pickingListTransfer, $userTransfer);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsNotFoundErrorWhenUserDoNotHaveWarehouseAssignment(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWithoutAssignmentWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiPost(
            $I->getStartPickingUrl($this->fixtures->getImmutableReadyForPickingPickingListTransfer()),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();

        $I->amSure('The returned error is correct')
            ->whenI()
            ->seePickingListNotFoundError();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsNotFoundErrorWhenUserWarehouseAssignmentIsInactive(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWithInactiveAssignmentWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiPost(
            $I->getStartPickingUrl($this->fixtures->getImmutableReadyForPickingPickingListTransfer()),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();

        $I->amSure('The returned error is correct')
            ->whenI()
            ->seePickingListNotFoundError();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsNotFoundErrorWhenUserIsNotWarehouseUser(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getNotWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiPost(
            $I->getStartPickingUrl($this->fixtures->getImmutableReadyForPickingPickingListTransfer()),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();

        $I->amSure('The returned error is correct')
            ->whenI()
            ->seePickingListNotFoundError();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsNotFoundErrorWhenNonExistingPickingListUuidIsProvided(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getMainWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiPost(
            $I->getStartPickingUrl((new PickingListTransfer())->setUuid('non-existing-uuid')),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();

        $I->amSure('The returned error is correct')
            ->whenI()
            ->seePickingListNotFoundError();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsConflictErrorWhenPickingListIsAlreadyAssignedToAnotherWarehouseUser(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getSecondaryWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiPost(
            $I->getStartPickingUrl($this->fixtures->getPickingStartedPickingListTransfer()),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::CONFLICT);
        $I->seeResponseIsJson();

        $I->amSure('The returned error has correct code')
            ->whenI()
            ->seeJsonApiResponseErrorsHaveCode(static::RESPONSE_CODE_PICKED_BY_ANOTHER_USER);
        $I->amSure('The returned error has correct message')
            ->whenI()
            ->seeJsonApiResponseErrorsHaveMessage(static::ERROR_DETAIL_PICKED_BY_ANOTHER_USER);
        $I->amSure('The returned error has correct status')
            ->whenI()
            ->seeJsonApiResponseErrorsHaveStatus(HttpCode::CONFLICT);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsUnauthorizedErrorResponseWhenAuthTokenIsNotProvided(PickingListsBackendApiTester $I): void
    {
        //Act
        $I->sendJsonApiPost(
            $I->getStartPickingUrl($this->fixtures->getImmutableReadyForPickingPickingListTransfer()),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
