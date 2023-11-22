<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Urls\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\Urls\UrlsRestApiTester;
use Spryker\Glue\UrlsRestApi\UrlsRestApiConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Urls
 * @group RestApi
 * @group UrlsRestApiCest
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class UrlsRestApiCest
{
    /**
     * @var string
     */
    protected const DEFAULT_LOCALE = 'en_US';

    /**
     * @var \PyzTest\Glue\Urls\RestApi\UrlsRestApiFixtures
     */
    protected UrlsRestApiFixtures $fixtures;

    /**
     * @param \PyzTest\Glue\Urls\UrlsRestApiTester $I
     *
     * @return void
     */
    public function loadFixtures(UrlsRestApiTester $I): void
    {
        /** @var \PyzTest\Glue\Urls\RestApi\UrlsRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(UrlsRestApiFixtures::class);

        $this->fixtures = $fixtures;
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Urls\UrlsRestApiTester $I
     *
     * @return void
     */
    public function requestNonExistingUrl(UrlsRestApiTester $I): void
    {
        // Act
        $I->sendGET(
            $I->formatUrl(
                '{resource}?url={url}',
                [
                    'resource' => UrlsRestApiConfig::RESOURCE_URL_RESOLVER,
                    'url' => 'none',
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Urls\UrlsRestApiTester $I
     *
     * @return void
     */
    public function requestUrlWithoutUrlParameter(UrlsRestApiTester $I): void
    {
        // Act
        $I->sendGET(
            $I->formatUrl(
                '{resource}',
                [
                    'resource' => UrlsRestApiConfig::RESOURCE_URL_RESOLVER,
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
        $I->seeResponseIsJson();
    }

    /**
     * @depends loadFixtures
     *
     * @param \PyzTest\Glue\Urls\UrlsRestApiTester $I
     *
     * @return void
     */
    public function requestExistingProductAbstractUrl(UrlsRestApiTester $I): void
    {
        // Arrange
        $localizedUrl = '';
        foreach ($this->fixtures->getProductUrlTransfer()->getUrls() as $localizedUrlTransfer) {
            if ($localizedUrlTransfer->getLocale()->getLocaleName() === static::DEFAULT_LOCALE) {
                $localizedUrl = $localizedUrlTransfer->getUrl();
            }
        }

        // Act
        $I->sendGET(
            $I->formatUrl(
                '{resource}?url={url}',
                [
                    'resource' => UrlsRestApiConfig::RESOURCE_URL_RESOLVER,
                    'url' => $localizedUrl,
                ],
            ),
        );

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseMatchesOpenApiSchema();

        $I->amSure('Returned resource collection consists of 1 item of type url-resolver')
            ->whenI()
            ->seeResponseDataContainsResourceCollectionOfTypeWithSizeOf(UrlsRestApiConfig::RESOURCE_URL_RESOLVER, 1);
    }
}
