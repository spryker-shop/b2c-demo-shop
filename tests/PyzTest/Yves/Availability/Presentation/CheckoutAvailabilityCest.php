<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Availability\Presentation;

use Codeception\Scenario;
use PyzTest\Yves\Availability\AvailabilityPresentationTester;
use PyzTest\Yves\Cart\PageObject\CartListPage;
use PyzTest\Yves\Product\PageObject\ProductDetailPage;
use PyzTest\Zed\Availability\PageObject\AvailabilityViewPage;
use PyzTest\Zed\Sales\PageObject\OrderDetailPage;
use PyzTest\Zed\Sales\PageObject\OrderListPage;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Availability
 * @group Presentation
 * @group CheckoutAvailabilityCest
 * Add your own group annotations below this line
 */
class CheckoutAvailabilityCest
{
    /**
     * @skip Require P&S functionality
     *
     * @param \PyzTest\Yves\Availability\AvailabilityPresentationTester $i
     * @param \Codeception\Scenario $scenario
     *
     * @return void
     */
    public function testCheckoutItemWithAvailability(AvailabilityPresentationTester $i, Scenario $scenario)
    {
        $i->wantTo('Checkout item with stock');
        $i->expectTo('Availability changed during SM processing.');
        $i->truncateSalesOrderThresholds();

        $i->amOnPage(AvailabilityPresentationTester::FUJITSU_PRODUCT_PAGE);

        $i->click(ProductDetailPage::ADD_TO_CART_XPATH);

        $i->see(CartListPage::CART_HEADER);
        $i->click(CartListPage::START_CHECKOUT_XPATH);

        $i->processCheckout();

        $i->amZed();
        $i->amLoggedInUser();

        $i->amOnPage(sprintf(AvailabilityViewPage::VIEW_PRODUCT_AVAILABILITY_URL, AvailabilityPresentationTester::FUJITSU_PRODUCT_ID));

        $i->waitForElementVisible(AvailabilityViewPage::AVAILABILITY_RESERVATION_XPATH, 30);
        $reservedProductsBefore = $i->grabTextFrom(AvailabilityViewPage::AVAILABILITY_RESERVATION_XPATH);

        $i->amOnPage(OrderListPage::ORDER_LIST_URL);

        $i->waitForElementVisible(OrderDetailPage::ORDER_DETAIL_TABLE_FIRST_ORDER_ID_XPATH, 30);
        $idSalesOrder = $i->grabTextFrom(OrderDetailPage::ORDER_DETAIL_TABLE_FIRST_ORDER_ID_XPATH);

        $i->amOnPage(sprintf(OrderDetailPage::ORDER_DETAIL_PAGE_URL, $idSalesOrder));

        $i->click(sprintf(OrderDetailPage::OMS_EVENT_TRIGGER_XPATH, 'pay'));
        $i->click(sprintf(OrderDetailPage::OMS_EVENT_TRIGGER_XPATH, 'ship'));
        $i->click(sprintf(OrderDetailPage::OMS_EVENT_TRIGGER_XPATH, 'stock-update'));
        $i->click(sprintf(OrderDetailPage::OMS_EVENT_TRIGGER_XPATH, 'return'));
        $i->click(sprintf(OrderDetailPage::OMS_EVENT_TRIGGER_XPATH, 'refund'));

        $i->amOnPage(sprintf(AvailabilityViewPage::VIEW_PRODUCT_AVAILABILITY_URL, AvailabilityPresentationTester::FUJITSU_PRODUCT_ID));

        $i->waitForElementVisible(AvailabilityViewPage::AVAILABILITY_RESERVATION_XPATH, 10);
        $reservedProductsAfter = $i->grabTextFrom(AvailabilityViewPage::AVAILABILITY_RESERVATION_XPATH);

        $i->assertEquals($reservedProductsAfter, $reservedProductsBefore - 1); //Reserved item returned back
    }
}
