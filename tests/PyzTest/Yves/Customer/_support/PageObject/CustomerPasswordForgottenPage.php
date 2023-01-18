<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Customer\PageObject;

class CustomerPasswordForgottenPage extends Customer
{
    /**
     * @var string
     */
    public const URL = '/en/password/forgotten';

    /**
     * @var string
     */
    public const TITLE_FORGOT_PASSWORD = 'Recover my password';

    /**
     * @var string
     */
    public const BUTTON_BACK = 'Back';

    /**
     * @var string
     */
    public const BUTTON_SUBMIT = 'Submit';

    /**
     * @var string
     */
    public const EMAIL_FIELD_SELECTOR = 'forgottenPassword[email]';
}
