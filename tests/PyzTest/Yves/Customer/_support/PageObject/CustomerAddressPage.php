<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Yves\Customer\PageObject;

class CustomerAddressPage extends Customer
{
    /**
     * @var string
     */
    public const URL = '/en/customer/address/new';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_SALUTATION = 'addressForm[salutation]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_FIRST_NAME = 'addressForm[first_name]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_LAST_NAME = 'addressForm[last_name]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_COMPANY = 'addressForm[company]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_PHONE = 'addressForm[phone]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_STREET = 'addressForm[address1]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_NUMBER = 'addressForm[address2]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_ADDITION_TO_ADDRESS = 'addressForm[address3]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_ZIP_CODE = 'addressForm[zip_code]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_CITY = 'addressForm[city]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_COUNTRY = 'addressForm[iso2_code]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_DEFAULT_SHIPPING = 'addressForm[is_default_shipping]';

    /**
     * @var string
     */
    public const FORM_FIELD_SELECTOR_DEFAULT_BILLING = 'addressForm[is_default_billing]';

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
    public const SUCCESS_MESSAGE = 'Address was successfully added';
}
