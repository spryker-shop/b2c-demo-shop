<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Yves\Customer\Presentation;

use Codeception\Scenario;
use PyzTest\Yves\Customer\CustomerPresentationTester;
use PyzTest\Yves\Customer\PageObject\CustomerLoginPage;
use PyzTest\Yves\Customer\PageObject\CustomerOverviewPage;
use PyzTest\Yves\Customer\PageObject\CustomerPasswordForgottenPage;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Customer
 * @group Presentation
 * @group CustomerLoginCest
 * Add your own group annotations below this line
 */
class CustomerLoginCest
{
    public function _before(CustomerPresentationTester $i): void
    {
        $i->amYves();
    }

    public function testICanOpenLoginPage(CustomerPresentationTester $i): void
    {
        $i->amOnPage(CustomerLoginPage::URL);
        $i->see(CustomerLoginPage::TITLE_LOGIN);
    }

    public function testICanOpenForgotPasswordPage(CustomerPresentationTester $i, Scenario $scenario): void
    {
        $scenario->skip('Test is outdated and needs to be actualized.');

        $i->amOnPage(CustomerLoginPage::URL);
        $i->click(CustomerLoginPage::FORGOT_PASSWORD_LINK);
        $i->seeCurrentUrlEquals(CustomerPasswordForgottenPage::URL);
    }

    public function testICanLoginWithValidData(CustomerPresentationTester $i): void
    {
        $i->amOnPage(CustomerLoginPage::URL);
        $customerTransfer = $i->haveRegisteredCustomer();
        $i->submitLoginForm($customerTransfer->getEmail(), $customerTransfer->getPassword());
        $i->wait(5);
        $i->seeCurrentUrlEquals(CustomerOverviewPage::URL);
    }
}
