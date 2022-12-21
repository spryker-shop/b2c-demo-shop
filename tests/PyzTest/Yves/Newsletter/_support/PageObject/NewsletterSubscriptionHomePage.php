<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Newsletter\PageObject;

class NewsletterSubscriptionHomePage
{
    /**
     * @var string
     */
    public const NEW_EMAIL = 'foo@bar.com';

    /**
     * @var string
     */
    public const EXISTING_EMAIL = 'bar@foo.com';

    /**
     * @var array
     */
    public const FORM_SELECTOR = ['id' => 'newsletterSubscriptionWidgetForm_subscribe'];

    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'You are already subscribed to the newsletter';

    /**
     * @var string
     */
    public const SUCCESS_MESSAGE = 'You successfully subscribed to the newsletter';

    /**
     * @var string
     */
    public const FORM_SUBMIT = '[data-qa="subscription-form__button"]';
}
