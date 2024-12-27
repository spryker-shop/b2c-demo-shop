<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Yves\Customer\PageObject;

class CustomerNewsletterPage extends Customer
{
    /**
     * @var string
     */
    public const URL = '/en/customer/newsletter';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_NEWSLETTER_SUBSCRIPTION = '[data-qa*="newsletterSubscriptionForm_subscribe"] label';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_NEWSLETTER_SUBSCRIPTION_INPUT = '[data-qa*="newsletterSubscriptionForm_subscribe"] input';

    /**
     * @var string
     */
    public const BUTTON_SUBMIT = 'Submit';

    /**
     * @var string
     */
    public const SUCCESS_MESSAGE_SUBSCRIBED = 'You successfully subscribed to the newsletter';

    /**
     * @var string
     */
    public const SUCCESS_MESSAGE_UN_SUBSCRIBED = 'You successfully unsubscribed from the newsletter';

    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'You are already subscribed to the newsletter';
}
