<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\PickingListsBackend\JsonApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\PickingListsBackendJsonApiFixtures;
use PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester;
use Spryker\Glue\PickingListsBackendApi\PickingListsBackendApiConfig;
use Spryker\Glue\ProductImageSetsBackendApi\ProductImageSetsBackendApiConfig;
use Spryker\Glue\ProductsBackendApi\ProductsBackendApiConfig;
use Spryker\Glue\SalesOrdersBackendApi\SalesOrdersBackendApiConfig;
use Spryker\Glue\ShipmentsBackendApi\ShipmentsBackendApiConfig;
use Spryker\Glue\UsersBackendApi\UsersBackendApiConfig;
use Spryker\Glue\WarehousesBackendApi\WarehousesBackendApiConfig;
use Spryker\Shared\PickingList\PickingListConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group PickingListsBackend
 * @group JsonApi
 * @group GetCollectionPickingListsBackendJsonApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class GetCollectionPickingListsBackendJsonApiCest
{
    /**
     * @var \PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\PickingListsBackendJsonApiFixtures
     */
    protected PickingListsBackendJsonApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function loadFixtures(PickingListsBackendApiTester $I): void
    {
        /** @var \PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\PickingListsBackendJsonApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(PickingListsBackendJsonApiFixtures::class);
        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionOfPickingListsResources(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiGet(
            $I->formatUrl(PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains collection of picking lists with correct size')
            ->whenI()
            ->seeJsonApiResponseDataContainsResourceCollectionOfTypeWithSizeOf(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
                2,
            );
        $I->amSure('The returned resource collection contains correct picking list')
            ->whenI()
            ->seeJsonApiResourceCollectionHasResourceWithId(
                $this->fixtures->getReadyForPickingPickingListTransfer()->getUuidOrFail(),
            );
        $I->amSure('The returned resource has correct self-link')
            ->whenI()
            ->seeJsonApiResourceByIdHasSelfLink(
                $this->fixtures->getReadyForPickingPickingListTransfer()->getUuidOrFail(),
                $I->getGetPickingListUrl($this->fixtures->getReadyForPickingPickingListTransfer()),
            );
        $I->amSure('The returned resource has correct self-link')
            ->whenI()
            ->seeJsonApiResourceByIdHasSelfLink(
                $this->fixtures->getPickingStartedPickingListTransfer()->getUuidOrFail(),
                $I->getGetPickingListUrl($this->fixtures->getPickingStartedPickingListTransfer()),
            );
        $I->amSure('The returned resource collection has correct self-link')
            ->whenI()
            ->seeJsonApiResponseLinksContainsSelfLink(
                $I->formatFullUrl(PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionFilteredByReadyForPickingStatus(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->formatFullUrl('{resourcePickingLists}?filter[picking-lists.status]={pickingListStatus}', [
            'resourcePickingLists' => PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
            'pickingListStatus' => PickingListConfig::STATUS_READY_FOR_PICKING,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains collection of picking lists with correct size')
            ->whenI()
            ->seeJsonApiResponseDataContainsResourceCollectionOfTypeWithSizeOf(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
                1,
            );
        $I->amSure('The returned resource collection contains correct picking list')
            ->whenI()
            ->seeJsonApiResourceCollectionHasResourceWithId(
                $this->fixtures->getReadyForPickingPickingListTransfer()->getUuidOrFail(),
            );
        $I->amSure('The returned resource has correct self-link')
            ->whenI()
            ->seeJsonApiResponseLinksContainsSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionFilteredByPickingStartedStatus(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->formatFullUrl('{resourcePickingLists}?filter[picking-lists.status]={pickingListStatus}', [
            'resourcePickingLists' => PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
            'pickingListStatus' => PickingListConfig::STATUS_PICKING_STARTED,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains collection of picking lists with correct size')
            ->whenI()
            ->seeJsonApiResponseDataContainsResourceCollectionOfTypeWithSizeOf(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
                1,
            );
        $I->amSure('The returned resource collection contains correct picking list')
            ->whenI()
            ->seeJsonApiResourceCollectionHasResourceWithId(
                $this->fixtures->getPickingStartedPickingListTransfer()->getUuidOrFail(),
            );
        $I->amSure('The returned resource has correct self-link')
            ->whenI()
            ->seeJsonApiResponseLinksContainsSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionWithIncludedPickingListItemsRelations(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getGetCollectionPickingListUrl([
            PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getReadyForPickingPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getPickingStartedPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionWithIncludedPickingListItemsAndSalesOrdersRelations(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getGetCollectionPickingListUrl([
            PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
            SalesOrdersBackendApiConfig::RESOURCE_SALES_ORDERS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getReadyForPickingPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getPickingStartedPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included sales orders')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                SalesOrdersBackendApiConfig::RESOURCE_SALES_ORDERS,
                $this->fixtures->getOrderTransfer1()->getOrderReferenceOrFail(),
            );
        $I->amSure('The returned resource contains included sales orders')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                SalesOrdersBackendApiConfig::RESOURCE_SALES_ORDERS,
                $this->fixtures->getOrderTransfer2()->getOrderReferenceOrFail(),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionWithIncludedPickingListItemsAndSalesShipmentsRelations(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getGetCollectionPickingListUrl([
            PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
            ShipmentsBackendApiConfig::RESOURCE_SALES_SHIPMENTS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getReadyForPickingPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getPickingStartedPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included sales shipments')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                ShipmentsBackendApiConfig::RESOURCE_SALES_SHIPMENTS,
                $this->fixtures->getOrderTransfer1()->getItems()->getIterator()->current()->getShipmentOrFail()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included sales shipments')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                ShipmentsBackendApiConfig::RESOURCE_SALES_SHIPMENTS,
                $this->fixtures->getOrderTransfer2()->getItems()->getIterator()->current()->getShipmentOrFail()->getUuidOrFail(),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionWithIncludedPickingListItemsAndConcreteProductsRelations(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getGetCollectionPickingListUrl([
            PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
            ProductsBackendApiConfig::RESOURCE_CONCRETE_PRODUCTS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getReadyForPickingPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getPickingStartedPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included concrete products')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                ProductsBackendApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                $this->fixtures->getProductConcreteTransfer()->getSkuOrFail(),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionWithIncludedPickingListItemsAndConcreteProductsAndConcreteProductImageSetsRelations(
        PickingListsBackendApiTester $I,
    ): void {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getGetCollectionPickingListUrl([
            PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
            ProductsBackendApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            ProductImageSetsBackendApiConfig::RESOURCE_CONCRETE_PRODUCT_IMAGE_SETS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getReadyForPickingPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getPickingStartedPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource contains included concrete products')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                ProductsBackendApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                $this->fixtures->getProductConcreteTransfer()->getSkuOrFail(),
            );
        $I->amSure('The returned resource contains included concrete product image sets')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                ProductImageSetsBackendApiConfig::RESOURCE_CONCRETE_PRODUCT_IMAGE_SETS,
                $this->fixtures->getProductConcreteTransfer()->getImageSets()->getIterator()->current()->getSkuOrFail(),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionWithIncludedUsersRelations(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getGetCollectionPickingListUrl([
            UsersBackendApiConfig::RESOURCE_TYPE_USERS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains included users')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                UsersBackendApiConfig::RESOURCE_TYPE_USERS,
                $this->fixtures->getWarehouseUserTransfer()->getUuidOrFail(),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsCollectionWithIncludedWarehouseRelations(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getGetCollectionPickingListUrl([
            WarehousesBackendApiConfig::RESOURCE_WAREHOUSES,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains included warehouses')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                WarehousesBackendApiConfig::RESOURCE_WAREHOUSES,
                $this->fixtures->getWarehouseTransfer()->getUuidOrFail(),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsEmptyCollectionWhenUserDoNotHaveWarehouseAssignment(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransferWithoutAssignment());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiGet(
            $I->formatUrl(PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains empty collection')
            ->whenI()
            ->seeJsonApiResponseDataContainsEmptyCollection();
        $I->amSure('The returned resource has correct self-link')
            ->whenI()
            ->seeJsonApiResponseLinksContainsSelfLink(
                $I->formatFullUrl(PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsEmptyCollectionWhenUserIsNotWarehouseUser(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiGet(
            $I->formatUrl(PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains empty collection')
            ->whenI()
            ->seeJsonApiResponseDataContainsEmptyCollection();
        $I->amSure('The returned resource has correct self-link')
            ->whenI()
            ->seeJsonApiResponseLinksContainsSelfLink(
                $I->formatFullUrl(PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS),
            );
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
        $I->sendJsonApiGet(
            $I->formatUrl(PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
