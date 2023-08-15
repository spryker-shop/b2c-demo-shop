<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\AppCatalogGui\Communication\Controller;

use PyzTest\Zed\AppCatalogGui\AppCatalogGuiCommunicationTester;
use PyzTest\Zed\AppCatalogGui\PageObject\AppCatalogGuiApiLoginPage;
use PyzTest\Zed\AppCatalogGui\PageObject\AppCatalogGuiIndexPage;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group AppCatalogGui
 * @group Communication
 * @group Controller
 * @group AppCatalogGuiControllerCest
 * Add your own group annotations below this line
 */
class AppCatalogGuiControllerCest
{
    /**
     * @var string
     */
    protected const STORE_REFERENCE = 'dev-DE';

    /**
     * @param \PyzTest\Zed\AppCatalogGui\AppCatalogGuiCommunicationTester $I
     *
     * @return void
     */
    public function checkIfAppCatalogGuiReturn200AndValidUrl(AppCatalogGuiCommunicationTester $I): void
    {
        if ($I->seeThatDynamicStoreEnabled()) {
            $I->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $I->amLoggedInUser();
        /** @var \Spryker\Zed\AppCatalogGui\AppCatalogGuiConfig $appCatalogGuiConfig */
        $appCatalogGuiConfig = $I->getModuleConfig();
        $storeTransfer = $I->getAllowedStore();
        $I->setStoreReferenceData([$storeTransfer->getName() => static::STORE_REFERENCE]);
        $locale = array_search(
            $storeTransfer->getDefaultLocaleIsoCode(),
            $storeTransfer->getAvailableLocaleIsoCodes(),
            true,
        );

        // Act
        $I->amOnPage(AppCatalogGuiIndexPage::APP_CATALOG_GUI_INDEX_PAGE_URL);

        // Assert
        $I->seeResponseCodeIs(200);
        $I->seeInSource(sprintf(
            AppCatalogGuiIndexPage::APP_CATALOG_SCRIPT,
            $appCatalogGuiConfig->getAppCatalogScriptUrl(),
            static::STORE_REFERENCE,
            $locale,
        ));
    }

    /**
     * @param \PyzTest\Zed\AppCatalogGui\AppCatalogGuiCommunicationTester $I
     *
     * @return void
     */
    public function checkIfAppCatalogGuiApiLoginReturn200AndValidToken(AppCatalogGuiCommunicationTester $I): void
    {
        if ($I->seeThatDynamicStoreEnabled()) {
            $I->markTestSkipped('Test is valid for Static Store mode only.');
        }

        // Arrange
        $I->amLoggedInUser();

        // Act
        $I->sendAjaxGetRequest(AppCatalogGuiApiLoginPage::APP_CATALOG_GUI_API_LOGIN_PAGE_URL);

        // Assert
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseJsonMatchesJsonPath('$.access_token');
        $I->assertIsString($I->grabDataFromResponseByJsonPath('$.access_token')[0]);
    }
}
