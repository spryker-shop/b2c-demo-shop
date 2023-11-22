<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\ProductLabels\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\ProductLabels\ProductLabelsApiTester;
use Spryker\Glue\ProductLabelsRestApi\ProductLabelsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group ProductLabels
 * @group RestApi
 * @group ProductConcreteProductLabelsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class ProductConcreteProductLabelsRestApiCest
{
    /**
     * @var \PyzTest\Glue\ProductLabels\RestApi\ProductLabelsRestApiFixtures
     */
    protected ProductLabelsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\ProductLabels\ProductLabelsApiTester $I
     *
     * @return void
     */
    public function loadFixtures(ProductLabelsApiTester $I): void
    {
        /** @var \PyzTest\Glue\ProductLabels\RestApi\ProductLabelsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(ProductLabelsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\ProductLabels\ProductLabelsApiTester $I
     *
     * @return void
     */
    public function requestProductConcreteWithProductLabelsRelationship(ProductLabelsApiTester $I): void
    {
        // Arrange
        $idProductLabel = $this->fixtures->getProductLabelTransfer()->getIdProductLabel();
        $url = $I->buildProductConcreteUrl(
            $this->fixtures->getProductConcreteTransferWithLabel()->getSku(),
            [
                ProductLabelsRestApiConfig::RESOURCE_PRODUCT_LABELS,
            ],
        );

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource has product-labels relationship')
            ->whenI()
            ->seeSingleResourceHasRelationshipByTypeAndId(
                ProductLabelsRestApiConfig::RESOURCE_PRODUCT_LABELS,
                $idProductLabel,
            );

        $I->amSure('The returned resource has product-labels include')
            ->whenI()
            ->seeIncludesContainsResourceByTypeAndId(
                ProductLabelsRestApiConfig::RESOURCE_PRODUCT_LABELS,
                $idProductLabel,
            );

        $I->amSure('The include has correct self-link')
            ->whenI()
            ->seeIncludedResourceByTypeAndIdHasSelfLink(
                ProductLabelsRestApiConfig::RESOURCE_PRODUCT_LABELS,
                $idProductLabel,
                $I->buildProductLabelUrl($idProductLabel),
            );
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\ProductLabels\ProductLabelsApiTester $I
     *
     * @return void
     */
    public function requestProductConcreteWithoutProductLabelRelationship(ProductLabelsApiTester $I): void
    {
        // Arrange
        $url = $I->buildProductConcreteUrl(
            $this->fixtures->getProductConcreteTransfer()->getSku(),
            [
                ProductLabelsRestApiConfig::RESOURCE_PRODUCT_LABELS,
            ],
        );

        // Act
        $I->sendGET($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('The returned resource does not have product-labels includes')
            ->whenI()
            ->dontSeeIncludesContainResourceOfType(ProductLabelsRestApiConfig::RESOURCE_PRODUCT_LABELS);
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\ProductLabels\ProductLabelsApiTester $I
     *
     * @return void
     */
    public function requestProductConcreteWithProductLabelRelationshipByPost(ProductLabelsApiTester $I): void
    {
        // Arrange
        $url = $I->buildProductConcreteUrl(
            $this->fixtures->getProductConcreteTransferWithLabel()->getSku(),
            [
                ProductLabelsRestApiConfig::RESOURCE_PRODUCT_LABELS,
            ],
        );

        // Act
        $I->sendPOST($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\ProductLabels\ProductLabelsApiTester $I
     *
     * @return void
     */
    public function requestProductConcreteWithProductLabelRelationshipByPatch(ProductLabelsApiTester $I): void
    {
        // Arrange
        $url = $I->buildProductConcreteUrl(
            $this->fixtures->getProductConcreteTransferWithLabel()->getSku(),
            [
                ProductLabelsRestApiConfig::RESOURCE_PRODUCT_LABELS,
            ],
        );

        // Act
        $I->sendPATCH($url);

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }
}
