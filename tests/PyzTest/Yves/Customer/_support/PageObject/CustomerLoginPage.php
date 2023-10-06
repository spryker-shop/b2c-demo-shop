<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Customer\PageObject;

class CustomerLoginPage extends Customer
{
    /**
     * @var string
     */
    public const URL = '/en/login';

    /**
     * @var string
     */
    public const LOGIN_URL = '/en/login';

    /**
     * @var string
     */
    public const FORGOT_PASSWORD_LINK = '[data-qa="customer-forgot-password-link"]';

    /**
     * @var string
     */
    public const TITLE_LOGIN = 'Login';

    /**
     * @var string
     */
    public const TITLE_FORGOT_PASSWORD = 'Recover my password';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_EMAIL = 'loginForm[email]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_PASSWORD = 'loginForm[password]';

    /**
     * @var string
     */
    public const FORM_NAME_LOGIN_FORM = 'loginForm';

    /**
     * @var array
     */
    public const LOGOUT_LINK = ['id' => 'logout-link'];
}
