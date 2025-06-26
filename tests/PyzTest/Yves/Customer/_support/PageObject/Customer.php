<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Yves\Customer\PageObject;

use Generated\Shared\Transfer\CustomerTransfer;

class Customer
{
    /**
     * @var string
     */
    public const NEW_CUSTOMER_EMAIL = 'new-customer@spryker.com';

    /**
     * @var string
     */
    public const REGISTERED_CUSTOMER_EMAIL = 'registered-customer@spryker.com';

    /**
     * @var array
     */
    protected static $customer = [
        self::NEW_CUSTOMER_EMAIL => [
            'salutation' => 'Mr',
            'firstName' => 'New',
            'lastName' => 'Customer',
            'email' => self::NEW_CUSTOMER_EMAIL,
            'password' => 'sP3yK3r%23!23',
        ],
        self::REGISTERED_CUSTOMER_EMAIL => [
            'salutation' => 'Mrs',
            'firstName' => 'Registered',
            'lastName' => 'Customer',
            'email' => self::REGISTERED_CUSTOMER_EMAIL,
            'password' => 'sP3yK3r%23!23',
        ],
    ];

    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public static function getCustomerData(string $email): CustomerTransfer
    {
        $customerTransfer = new CustomerTransfer();
        $customerTransfer->fromArray(self::$customer[$email]);

        return $customerTransfer;
    }
}
