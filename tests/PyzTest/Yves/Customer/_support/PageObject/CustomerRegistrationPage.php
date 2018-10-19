<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Customer\PageObject;

class CustomerRegistrationPage extends Customer
{
    public const URL = '/register';

    public const TITLE_CREATE_ACCOUNT = 'Sign Up';

    public const BUTTON_REGISTER = 'Sign Up';
    public const RADIO_BUTTON_REGISTER = 'toggler-radio[data-qa*="register"]';

    public const FORM_FIELD_SELECTOR_SALUTATION = 'registerForm[salutation]';
    public const FORM_FIELD_SELECTOR_FIRST_NAME = 'registerForm[first_name]';
    public const FORM_FIELD_SELECTOR_LAST_NAME = 'registerForm[last_name]';
    public const FORM_FIELD_SELECTOR_EMAIL = 'registerForm[email]';
    public const FORM_FIELD_SELECTOR_PASSWORD = 'registerForm[password][pass]';
    public const FORM_FIELD_SELECTOR_PASSWORD_CONFIRM = 'registerForm[password][confirm]';
    public const FORM_FIELD_SELECTOR_ACCEPT_TERMS = '[data-qa*="registerForm_accept_terms"] label';

    public const SUCCESS_MESSAGE = 'Registration Successful';
}
