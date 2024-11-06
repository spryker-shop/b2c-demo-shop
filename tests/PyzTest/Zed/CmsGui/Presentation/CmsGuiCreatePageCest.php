<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\CmsGui\Presentation;

use Codeception\Scenario;
use PyzTest\Zed\CmsGui\CmsGuiPresentationTester;
use PyzTest\Zed\CmsGui\PageObject\CmsCreateGlossaryPage;
use PyzTest\Zed\CmsGui\PageObject\CmsCreatePage;
use PyzTest\Zed\CmsGui\PageObject\CmsEditPage;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group CmsGui
 * @group Presentation
 * @group CmsGuiCreatePageCest
 * Add your own group annotations below this line
 */
class CmsGuiCreatePageCest
{
    /**
     * @param \PyzTest\Zed\CmsGui\CmsGuiPresentationTester $i
     *
     * @return void
     */
    public function _before(CmsGuiPresentationTester $i): void
    {
        $i->amZed();
        $i->amLoggedInUser();
    }

    /**
     * @todo Add P&S check after it is available
     *
     * @param \PyzTest\Zed\CmsGui\CmsGuiPresentationTester $i
     * @param \Codeception\Scenario $scenario
     *
     * @return void
     */
    public function testICanCreateCmsPageWithTranslatedPlaceholders(CmsGuiPresentationTester $i, Scenario $scenario): void
    {
        $i->wantTo('Create cms page with multiple translations');
        $i->expect('Page is persisted in Zed, exported to Yves and is accessible.');

        $i->amLoggedInUser();
        $i->amOnPage(CmsCreatePage::URL);
        $i->selectOption('//*[@id="cms_page_fkTemplate"]', 'Placeholders Title & Content');
        $i->setValidFrom('1985-07-01');
        $i->setValidTo('2030-07-01');
        $i->setIsSearchable();

        $i->fillLocalizedUrlForm(0, $i->getLocalizedName('en'), $i->getLocalizedUrl('en'));
        $i->expandLocalizedUrlPane();
        $i->fillLocalizedUrlForm(1, $i->getLocalizedName('de'), $i->getLocalizedUrl('de'));
        $i->clickSubmit();

        $i->see(CmsCreatePage::PAGE_CREATED_SUCCESS_MESSAGE);

        $i->includeJquery();

        $i->fillPlaceholderContents(0, 0, CmsCreateGlossaryPage::getLocalizedPlaceholderData('title', 'en'));
        $i->fillPlaceholderContents(0, 1, CmsCreateGlossaryPage::getLocalizedPlaceholderData('title', 'de'));

        $i->fillPlaceholderContents(1, 0, CmsCreateGlossaryPage::getLocalizedPlaceholderData('contents', 'en'));
        $i->fillPlaceholderContents(1, 1, CmsCreateGlossaryPage::getLocalizedPlaceholderData('contents', 'de'));

        $i->clickSubmit();

        $idCmsPage = $i->grabCmsPageId();

        $i->amOnPage(sprintf(CmsEditPage::URL, $idCmsPage));

        $i->clickPublishButton();

        $i->see(CmsEditPage::PAGE_PUBLISH_SUCCESS_MESSAGE);
    }
}
