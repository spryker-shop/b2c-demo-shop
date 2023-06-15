<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Newsletter\Presentation;

use Generated\Shared\DataBuilder\CustomerBuilder;
use PyzTest\Yves\Application\PageObject\Homepage;
use PyzTest\Yves\Customer\PageObject\CustomerNewsletterPage;
use PyzTest\Yves\Customer\PageObject\CustomerOverviewPage;
use PyzTest\Yves\Newsletter\NewsletterPresentationTester;
use PyzTest\Yves\Newsletter\PageObject\NewsletterSubscriptionHomePage;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Newsletter
 * @group Presentation
 * @group NewsletterSubscriptionCest
 * Add your own group annotations below this line
 */
class NewsletterSubscriptionCest
{
    /**
     * @param \PyzTest\Yves\Newsletter\NewsletterPresentationTester $i
     *
     * @return void
     */
    public function iCanSubscribeWithAnUnsubscribedEmail(NewsletterPresentationTester $i): void
    {
        $i->wantTo('Subscribe to the newsletter with an unsubscribed new email.');
        $i->expect('Success message is displayed.');

        $i->amOnPage(Homepage::URL_EN);

        $customerTransfer = $this->buildCustomerTransfer();

        $i->fillField(NewsletterSubscriptionHomePage::FORM_SELECTOR, $customerTransfer->getEmail());
        $i->click(NewsletterSubscriptionHomePage::FORM_SUBMIT);

        $i->see(NewsletterSubscriptionHomePage::SUCCESS_MESSAGE);
    }

    /**
     * @param \PyzTest\Yves\Newsletter\NewsletterPresentationTester $i
     *
     * @return void
     */
    public function iCanNotSubscribeWithAnAlreadySubscribedEmail(NewsletterPresentationTester $i): void
    {
        $i->wantTo('Subscribe to the newsletter with an already subscribed email.');
        $i->expect('Error message is displayed.');

        $i->amOnPage(Homepage::URL_EN);

        $customerTransfer = $this->buildCustomerTransfer();

        $i->haveAnAlreadySubscribedEmail($customerTransfer->getEmail());

        $i->fillField(NewsletterSubscriptionHomePage::FORM_SELECTOR, $customerTransfer->getEmail());
        $i->click(NewsletterSubscriptionHomePage::FORM_SUBMIT);

        $i->see(NewsletterSubscriptionHomePage::ERROR_MESSAGE);
    }

    /**
     * @param \PyzTest\Yves\Newsletter\NewsletterPresentationTester $i
     *
     * @return void
     */
    public function subscribedEmailIsLinkedWithCustomerAfterRegistration(NewsletterPresentationTester $i): void
    {
        $i->wantTo('Subscribe to the newsletter with an unsubscribed email and later on register with that address.');
        $i->expect('Subscriber email should be linked with registered customer.');

        $i->amOnPage(Homepage::URL_EN);

        $customerTransfer = $this->buildCustomerTransfer();

        $i->fillField(NewsletterSubscriptionHomePage::FORM_SELECTOR, $customerTransfer->getEmail());
        $i->click(NewsletterSubscriptionHomePage::FORM_SUBMIT);

        $i->amLoggedInCustomer($customerTransfer->toArray());

        $i->amOnPage(CustomerOverviewPage::URL);
        $i->see(CustomerOverviewPage::NEWSLETTER_SUBSCRIBED);
    }

    /**
     * @param \PyzTest\Yves\Newsletter\NewsletterPresentationTester $i
     *
     * @return void
     */
    public function subscribedEmailCanBeUnsubscribedByCustomerAfterRegistration(NewsletterPresentationTester $i): void
    {
        $i->wantTo('Subscribe to the newsletter with an unsubscribed email should be able to unsubscribe after registration.');
        $i->expect('Subscribed email should be unsubscribed after customer unsubscribe.');

        $i->amOnPage(Homepage::URL);

        $customerTransfer = $this->buildCustomerTransfer();

        $i->fillField(NewsletterSubscriptionHomePage::FORM_SELECTOR, $customerTransfer->getEmail());
        $i->click(NewsletterSubscriptionHomePage::FORM_SUBMIT);

        $i->amLoggedInCustomer($customerTransfer->toArray());

        $i->amOnPage(CustomerOverviewPage::URL);
        $i->see(CustomerOverviewPage::NEWSLETTER_SUBSCRIBED);

        $i->amOnPage(CustomerNewsletterPage::URL);
        $i->amOnPage(CustomerNewsletterPage::URL);
        $i->click(CustomerNewsletterPage::FORM_FIELD_SELECTOR_NEWSLETTER_SUBSCRIPTION);
        $i->click(CustomerNewsletterPage::BUTTON_SUBMIT);
        $i->seeInSource(CustomerNewsletterPage::SUCCESS_MESSAGE_UN_SUBSCRIBED);

        $i->dontSeeCheckboxIsChecked(CustomerNewsletterPage::FORM_FIELD_SELECTOR_NEWSLETTER_SUBSCRIPTION_INPUT);
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer|\Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    protected function buildCustomerTransfer()
    {
        $customerTransfer = (new CustomerBuilder())->build();

        return $customerTransfer;
    }
}
