<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Tax\PageObject;

class TaxRateCreatePage
{
    /**
     * @var string
     */
    public const URL = '/tax/rate/create';

    /**
     * @var string
     */
    public const HEADER = 'Create new tax rate';

    /**
     * @var string
     */
    public const SELECTOR_HEADER = 'h2';

    /**
     * @var string
     */
    public const MESSAGE_SUCCESSFUL_ALERT_CREATION = '/Tax rate [0-9]+ was created successfully\\./';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_NAME_SHOULD_NOT_BE_BLANK = 'This value should not be blank.';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_COUNTRY_SHOULD_NOT_BE_BLANK = 'Select country.';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_PERCENTAGE_SHOULD_BE_VALID_RANGE = 'This value should be between 0 and 100.';

    /**
     * @var string
     */
    public const ERROR_MESSAGE_TAX_RATE_ALREADY_EXISTS = 'Tax rate with provided name, percentage and country already exists.';

    /**
     * @var string
     */
    public const MESSAGE_SUCCESSFUL_ALERT_UPDATE = 'Tax rate successfully updated.';

    /**
     * @var string
     */
    public const SELECTOR_NAME = '#tax_rate_name';

    /**
     * @var string
     */
    public const SELECTOR_COUNTRY = '#tax_rate_fkCountry';

    /**
     * @var string
     */
    public const SELECTOR_PERCENTAGE = '#tax_rate_rate';

    /**
     * @var string
     */
    public const SELECTOR_DELETE_FROM_EDIT = 'i.fa.fa-trash';

    /**
     * @var string
     */
    public const SELECTOR_SAVE = 'input.btn.btn-primary';

    /**
     * @var string
     */
    public const SELECTOR_LIST_OF_TAX_RATES_BUTTON = '//div[@class="title-action"]/a';

    /**
     * @var string
     */
    public const TAX_RATE_VALID = 'validTaxRate';

    /**
     * @var string
     */
    public const TAX_RATE_INVALID = 'invalidTaxRate';

    /**
     * @var string
     */
    public const TAX_RATE_VALID_NOT_CREATED = 'validTaxRateNotCreated';

    /**
     * @var string
     */
    public const TAX_RATE_VALID_EDITED = 'validTaxRateEdited';

    /**
     * @var array
     */
    public static $taxRateData = [
        self::TAX_RATE_VALID => [
            'name' => 'Acceptance Standard',
            'country' => 'Germany',
            'percentage' => '5',
        ],
        self::TAX_RATE_INVALID => [
            'name' => '',
            'country' => 'No country',
            'percentage' => '888',
        ],
        self::TAX_RATE_VALID_NOT_CREATED => [
            'name' => 'Acceptance Standard Not Created',
            'country' => 'Germany',
            'percentage' => '5',
        ],
        self::TAX_RATE_VALID_EDITED => [
            'name' => 'Acceptance Standard Edited',
            'country' => 'Germany',
            'percentage' => '10',
        ],
    ];
}
