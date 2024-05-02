<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\PickingListsBackend\JsonApi;

use Codeception\Util\HttpCode;
use Generated\Shared\Transfer\PickingListTransfer;
use PyzTest\Glue\PickingListsBackend\JsonApi\Fixtures\PickingListsBackendJsonApiFixtures;
use PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester;
use Spryker\Glue\PickingListsBackendApi\PickingListsBackendApiConfig;
use Spryker\Glue\ProductImageSetsBackendApi\ProductImageSetsBackendApiConfig;
use Spryker\Glue\ProductsBackendApi\ProductsBackendApiConfig;
use Spryker\Glue\SalesOrdersBackendApi\SalesOrdersBackendApiConfig;
use Spryker\Glue\ShipmentsBackendApi\ShipmentsBackendApiConfig;
use Spryker\Glue\UsersBackendApi\UsersBackendApiConfig;
use Spryker\Glue\WarehousesBackendApi\WarehousesBackendApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group PickingListsBackend
 * @group JsonApi
 * @group GetPickingListsBackendJsonApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class GetPickingListsBackendJsonApiCest
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
    public function requestReturnsCorrectPickingListsResourceByUuid(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getGetPickingListUrl($this->fixtures->getPickingStartedPickingListTransfer());

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource contains single picking list')
            ->whenI()
            ->seeJsonApiResponseDataContainsSingleResourceOfType(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
            );
        $I->amSure('The returned resource has correct ID')
            ->whenI()
            ->seeJsonApiSingleResourceIdEqualTo(
                $this->fixtures->getPickingStartedPickingListTransfer()->getUuidOrFail(),
            );
        $I->amSure('The returned resource has correct self link')
            ->whenI()
            ->seeJsonApiSingleResourceHasSelfLink($url);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\PickingListsBackend\PickingListsBackendApiTester $I
     *
     * @return void
     */
    public function requestReturnsIncludedPickingListItemsRelations(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->formatFullUrl('{resourcePickingLists}/{pickingListUuid}?include={resourcePickingListItems}', [
            'resourcePickingLists' => PickingListsBackendApiConfig::RESOURCE_PICKING_LISTS,
            'resourcePickingListItems' => PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
            'pickingListUuid' => $this->fixtures->getPickingStartedPickingListTransfer()->getUuidOrFail(),
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource includes correct picking list items')
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
    public function requestReturnsIncludedPickingListItemsAndSalesOrdersRelations(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        $url = $I->getGetPickingListUrl($this->fixtures->getPickingStartedPickingListTransfer(), [
            PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
            SalesOrdersBackendApiConfig::RESOURCE_SALES_ORDERS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource includes correct picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getPickingStartedPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource includes correct sales orders')
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

        $url = $I->getGetPickingListUrl($this->fixtures->getPickingStartedPickingListTransfer(), [
            'resourcePickingListItems' => PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
            'resourceSalesShipments' => ShipmentsBackendApiConfig::RESOURCE_SALES_SHIPMENTS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource includes correct picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getPickingStartedPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource includes correct sales orders')
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

        $url = $I->getGetPickingListUrl($this->fixtures->getPickingStartedPickingListTransfer(), [
            'resourcePickingListItems' => PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
            'resourceConcreteProducts' => ProductsBackendApiConfig::RESOURCE_CONCRETE_PRODUCTS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource includes correct picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getPickingStartedPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource includes correct concrete products')
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

        $url = $I->getGetPickingListUrl($this->fixtures->getPickingStartedPickingListTransfer(), [
            'resourcePickingListItems' => PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
            'resourceConcreteProducts' => ProductsBackendApiConfig::RESOURCE_CONCRETE_PRODUCTS,
            'resourceConcreteProductImageSets' => ProductImageSetsBackendApiConfig::RESOURCE_CONCRETE_PRODUCT_IMAGE_SETS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource includes correct picking list items')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                PickingListsBackendApiConfig::RESOURCE_PICKING_LIST_ITEMS,
                $this->fixtures->getPickingStartedPickingListTransfer()->getPickingListItems()->getIterator()->current()->getUuidOrFail(),
            );
        $I->amSure('The returned resource includes correct concrete products')
            ->whenI()
            ->seeJsonApiIncludesContainsResourceByTypeAndId(
                ProductsBackendApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                $this->fixtures->getProductConcreteTransfer()->getSkuOrFail(),
            );
        $I->amSure('The returned resource includes correct concrete product image sets')
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

        $url = $I->getGetPickingListUrl($this->fixtures->getPickingStartedPickingListTransfer(), [
            UsersBackendApiConfig::RESOURCE_TYPE_USERS,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource includes correct users')
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

        $url = $I->getGetPickingListUrl($this->fixtures->getPickingStartedPickingListTransfer(), [
            WarehousesBackendApiConfig::RESOURCE_WAREHOUSES,
        ]);

        //Act
        $I->sendJsonApiGet($url);

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource includes correct warehouses')
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
    public function requestReturnsNotFoundErrorWhenUserDoNotHaveWarehouseAssignment(PickingListsBackendApiTester $I): void
    {
        //Arrange
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransferWithoutAssignment());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiGet(
            $I->getGetPickingListUrl($this->fixtures->getReadyForPickingPickingListTransfer()),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

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
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiGet(
            $I->getGetPickingListUrl($this->fixtures->getReadyForPickingPickingListTransfer()),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

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
        $oauthResponseTransfer = $I->havePasswordAuthorizationToBackendApi($this->fixtures->getWarehouseUserTransfer());
        $I->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());

        //Act
        $I->sendJsonApiGet(
            $I->getGetPickingListUrl((new PickingListTransfer())->setUuid('non-existing-uuid')),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

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
    public function requestReturnsUnauthorizedErrorResponseWhenAuthTokenIsNotProvided(PickingListsBackendApiTester $I): void
    {
        //Act
        $I->sendJsonApiGet(
            $I->getGetPickingListUrl($this->fixtures->getReadyForPickingPickingListTransfer()),
        );

        //Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
