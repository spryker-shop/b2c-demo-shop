<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Availability\Presentation;

use PyzTest\Yves\Availability\AvailabilityPresentationTester;
use PyzTest\Yves\Cart\PageObject\CartListPage;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Availability
 * @group Presentation
 * @group AvailabilityAddToCartCest
 * Add your own group annotations below this line
 */
class AvailabilityAddToCartCest
{
    /**
     * @param \PyzTest\Yves\Availability\AvailabilityPresentationTester $i
     *
     * @return void
     */
    public function testAddToCartWhenBiggerQuantityIsUsed(AvailabilityPresentationTester $i)
    {
        $i->wantTo('Open product page, and add item to cart with larger quantity than available');
        $i->expectTo('Display error message');

        $i->amLoggedInCustomer();

        $i->amOnPage(AvailabilityPresentationTester::ADD_FUJITSU2_PRODUCT_TO_CART_URL);

        $i->see(CartListPage::CART_HEADER);

//        $i->fillField(CartListPage::FIRST_CART_ITEM_QUANTITY_INPUT_XPATH, 50);
//        $i->click(CartListPage::FIRST_CART_ITEM_CHANGE_QUANTITY_BUTTON_XPATH);
//
//        $i->seeInSource(AvailabilityPresentationTester::CART_PRE_CHECK_AVAILABILITY_ERROR_MESSAGE);
    }
}
