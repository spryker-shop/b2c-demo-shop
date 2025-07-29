<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Yves\Customer\Presentation;

use PyzTest\Yves\Customer\CustomerPresentationTester;
use PyzTest\Yves\Customer\PageObject\CustomerAddressesPage;
use PyzTest\Yves\Customer\PageObject\CustomerNewsletterPage;
use PyzTest\Yves\Customer\PageObject\CustomerOrdersPage;
use PyzTest\Yves\Customer\PageObject\CustomerOverviewPage;
use PyzTest\Yves\Customer\PageObject\CustomerProfilePage;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Customer
 * @group Presentation
 * @group CustomerOverviewCest
 * Add your own group annotations below this line
 */
class CustomerOverviewCest
{
    /**
     * @param \PyzTest\Yves\Customer\CustomerPresentationTester $i
     *
     * @return void
     */
    public function _before(CustomerPresentationTester $i): void
    {
        $i->amYves();
    }

    /**
     * @param \PyzTest\Yves\Customer\CustomerPresentationTester $i
     *
     * @return void
     */
    public function testICanOpenOverviewPage(CustomerPresentationTester $i): void
    {
        $i->amLoggedInCustomer();
        $i->amOnPage(CustomerOverviewPage::URL);

        $i->see(CustomerOverviewPage::BOX_HEADLINE_ORDERS, 'h2');
        $i->see(CustomerOverviewPage::BOX_HEADLINE_PROFILE, 'h2');
        $i->see(CustomerOverviewPage::BOX_HEADLINE_NEWSLETTER, 'h2');
    }

    /**
     * @param \PyzTest\Yves\Customer\CustomerPresentationTester $i
     *
     * @return void
     */
    public function testCustomerWithoutAddressShouldSeeAddAddressInfoText(CustomerPresentationTester $i): void
    {
        $i->amLoggedInCustomer();
        $i->amOnPage(CustomerOverviewPage::URL);

        // $i->see(CustomerOverviewPage::INFO_TEXT_ADD_SHIPPING_ADDRESS);
        // $i->see(CustomerOverviewPage::INFO_TEXT_ADD_BILLING_ADDRESS);
    }

    /**
     * @param \PyzTest\Yves\Customer\CustomerPresentationTester $i
     *
     * @return void
     */
    public function testICanGoFromOverviewToProfilePage(CustomerPresentationTester $i): void
    {
        $i->amLoggedInCustomer();
        $i->amOnPage(CustomerOverviewPage::URL);
        $i->click(CustomerOverviewPage::LINK_TO_PROFILE_PAGE);
        $i->amOnPage(CustomerProfilePage::URL);
    }

    /**
     * @param \PyzTest\Yves\Customer\CustomerPresentationTester $i
     *
     * @return void
     */
    public function testICanGoFromOverviewToAddressesPage(CustomerPresentationTester $i): void
    {
        $i->amLoggedInCustomer();
        $i->amOnPage(CustomerOverviewPage::URL);
        $i->click(CustomerOverviewPage::LINK_TO_ADDRESSES_PAGE);
        $i->amOnPage(CustomerAddressesPage::URL);
    }

    /**
     * @param \PyzTest\Yves\Customer\CustomerPresentationTester $i
     *
     * @return void
     */
    public function testICanGoFromOverviewToOrdersPage(CustomerPresentationTester $i): void
    {
        $i->amLoggedInCustomer();
        $i->amOnPage(CustomerOverviewPage::URL);
        $i->click(CustomerOverviewPage::LINK_TO_ORDERS_PAGE);
        $i->amOnPage(CustomerOrdersPage::URL);
    }

    /**
     * @param \PyzTest\Yves\Customer\CustomerPresentationTester $i
     *
     * @return void
     */
    public function testICanGoFromOverviewToNewsletterPage(CustomerPresentationTester $i): void
    {
        $i->amLoggedInCustomer();
        $i->amOnPage(CustomerOverviewPage::URL);
        $i->click(CustomerOverviewPage::LINK_TO_NEWSLETTER_PAGE);
        $i->amOnPage(CustomerNewsletterPage::URL);
    }
}
