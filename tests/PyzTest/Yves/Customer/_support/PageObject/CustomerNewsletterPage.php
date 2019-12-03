<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Customer\PageObject;

class CustomerNewsletterPage extends Customer
{
    public const URL = '/en/customer/newsletter';

    public const FORM_FIELD_SELECTOR_NEWSLETTER_SUBSCRIPTION = '[data-qa*="newsletterSubscriptionForm_subscribe"] label';
    public const FORM_FIELD_SELECTOR_NEWSLETTER_SUBSCRIPTION_INPUT = '[data-qa*="newsletterSubscriptionForm_subscribe"] input';

    public const BUTTON_SUBMIT = 'Submit';

    public const SUCCESS_MESSAGE_SUBSCRIBED = 'You successfully subscribed to the newsletter';
    public const SUCCESS_MESSAGE_UN_SUBSCRIBED = 'You successfully unsubscribed from the newsletter';
    public const ERROR_MESSAGE = 'You are already subscribed to the newsletter';
}
