<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Yves\Customer\PageObject;

class CustomerRegistrationPage extends Customer
{
    /**
     * @var string
     */
    public const URL = '/register';

    /**
     * @var string
     */
    public const TITLE_CREATE_ACCOUNT = 'Sign Up';

    /**
     * @var string
     */
    public const BUTTON_REGISTER = '[data-qa="submit-button"]';

    /**
     * @var string
     */
    public const RADIO_BUTTON_REGISTER = 'toggler-radio[data-qa*="register"]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_SALUTATION = 'registerForm[salutation]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_FIRST_NAME = 'registerForm[first_name]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_LAST_NAME = 'registerForm[last_name]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_EMAIL = 'registerForm[email]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_PASSWORD = 'registerForm[password][pass]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_PASSWORD_CONFIRM = 'registerForm[password][confirm]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_ACCEPT_TERMS = '[data-qa*="registerForm_accept_terms"] label';

    /**
     * @var string
     */
    public const SUCCESS_MESSAGE = 'Registration Successful';

    /**
     * @var string
     */
    public const CONFIRM_YOUR_ACCOUNT_MESSAGE = 'Almost there! We send you an email to validate your email address. Please confirm it to be able to log in.';
}
