<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Yves\Customer\PageObject;

class CustomerOverviewPage extends Customer
{
    /**
     * @var string
     */
    public const URL = '/en/customer/overview';

    /**
     * @var string
     */
    public const BOX_HEADLINE_ORDERS = 'Last orders';

    /**
     * @var string
     */
    public const BOX_HEADLINE_PROFILE = 'Profile';

    /**
     * @var string
     */
    public const BOX_HEADLINE_NEWSLETTER = 'Newsletter';

    /**
     * @var string
     */
    public const NEWSLETTER_SUBSCRIBED = 'Newsletter';

    /**
     * @var string
     */
    public const BOX_HEADLINE_BILLING_ADDRESS = 'Default Billing Address';

    /**
     * @var string
     */
    public const BOX_HEADLINE_SHIPPING_ADDRESS = 'Default Shipping Address';

    /**
     * @var string
     */
    public const LINK_TO_PROFILE_PAGE = '[data-qa="customer-account-sidebar"] a[data-id="sidebar-profile"]';//'Profile';

    /**
     * @var string
     */
    public const LINK_TO_ADDRESSES_PAGE = '[data-qa="customer-account-sidebar"] a[data-id="sidebar-address"]';//'Addresses';

    /**
     * @var string
     */
    public const LINK_TO_ORDERS_PAGE = '[data-qa="customer-account-sidebar"] a[data-id="sidebar-order"]';//'Orders History';

    /**
     * @var string
     */
    public const LINK_TO_NEWSLETTER_PAGE = '[data-qa="customer-account-sidebar"] a[data-id="sidebar-newsletter"]';//'Newsletter';

    /**
     * @var string
     */
    public const INFO_TEXT_ADD_SHIPPING_ADDRESS = 'Please Specify Shipping Address';

    /**
     * @var string
     */
    public const INFO_TEXT_ADD_BILLING_ADDRESS = 'Please Specify Billing Address';
}
