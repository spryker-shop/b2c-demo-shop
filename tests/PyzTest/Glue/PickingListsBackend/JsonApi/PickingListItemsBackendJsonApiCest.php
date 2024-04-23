<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\PickingListsBackend\JsonApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\PickingListItemTransfer;
use PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\PickingListItemsBackendJsonApiFixtures;
use PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester;
use Spryker\Glue\PickingListsBackendApi\PickingListsBackendApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group PickingListsBackend
 * @group JsonApi
 * @group PickingListItemsBackendJsonApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class PickingListItemsBackendJsonApiCest
{
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
     * @var \PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\PickingListItemsBackendJsonApiFixtures
     */
    protected PickingListItemsBackendJsonApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function loadFixtures(PickingListsBackendApiTester $I): void
    {
        /** @var \PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\PickingListItemsBackendJsonApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(PickingListItemsBackendJsonApiFixtures::class);
        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestDoesNotChangesPickingListStatusWhenPickingIsNotComplete(
        PickingListsBackendApiTester $I,
    ): void {
        // Arrange
        $pickingListTransfer = $this->fixtures->getTwoItemsPickingListTransfer();
        $pickingListItemTransfer = $pickingListTransfer->getPickingListItems()->getIterator()->current();

        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getPickingListItemUrl($pickingListTransfer);
        $requestData = [
            'data' => [
                [
                    'id' => $pickingListItemTransfer->getUuidOrFail(),
                    'type' => PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                    'attributes' => [
                        PickingListItemTransfer::NUMBER_OF_PICKED => 1,
                        PickingListItemTransfer::NUMBER_OF_NOT_PICKED => 0,
                    ],
                ],
            ],
        ];

        // Act
        $I->sendJsonApiPatch($url, $requestData);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->amSure('The returned resource contains collection of picking lists with correct size')
            ->whenI()
            ->seeJsonApiResponseDataContainsResourceCollectionOfTypeWithSizeOf(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
                1,
            );
        $I->amSure('The returned resource collection contains correct picking list')
            ->whenI()
            ->seeJsonApiResourceCollectionHasResourceWithId($pickingListTransfer->getUuidOrFail());
        $I->amSure('The returned picking list has correct status')
            ->whenI()
            ->seeCollectionResponsePickingListHaveCorrectStatus(static::STATUS_PICKING_STARTED);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestChangesPickingListStatusToPickingFinishedWhenPickingIsComplete(
        PickingListsBackendApiTester $I,
    ): void {
        // Arrange
        $pickingListTransfer = $this->fixtures->getOneItemPickingListTransfer();
        $pickingListItemTransfer = $pickingListTransfer->getPickingListItems()->getIterator()->current();

        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getPickingListItemUrl($pickingListTransfer);
        $requestData = [
            'data' => [
                [
                    'type' => PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                    'id' => $pickingListItemTransfer->getUuidOrFail(),
                    'attributes' => [
                        PickingListItemTransfer::NUMBER_OF_PICKED => 1,
                        PickingListItemTransfer::NUMBER_OF_NOT_PICKED => 0,
                    ],
                ],
            ],
        ];

        // Act
        $I->sendJsonApiPatch($url, $requestData);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->amSure('The returned resource contains collection of picking lists with correct size')
            ->whenI()
            ->seeJsonApiResponseDataContainsResourceCollectionOfTypeWithSizeOf(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
                1,
            );
        $I->amSure('The returned resource collection contains correct picking list')
            ->whenI()
            ->seeJsonApiResourceCollectionHasResourceWithId($pickingListTransfer->getUuidOrFail());
        $I->amSure('The returned picking list has correct status')
            ->whenI()
            ->seeCollectionResponsePickingListHaveCorrectStatus(static::STATUS_PICKING_FINISHED);
    }
}
