<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\Availability\PageObject;

class AvailabilityViewPage
{
    /**
     * @var string
     */
    public const VIEW_PRODUCT_AVAILABILITY_URL = '/availability-gui/index/view?id-product=%d&id-store=1';

    /**
     * @var string
     */
    public const AVAILABILITY_RESERVATION_XPATH = '//*[@id="availability-table"]/tbody/tr/td[5]';
}
