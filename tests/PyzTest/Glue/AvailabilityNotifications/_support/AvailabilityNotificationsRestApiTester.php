<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\AvailabilityNotifications;

use Spryker\Glue\AvailabilityNotificationsRestApi\AvailabilityNotificationsRestApiConfig;
use SprykerTest\Glue\Testify\Tester\ApiEndToEndTester;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(\PyzTest\Glue\AvailabilityNotifications\PHPMD)
 */
class AvailabilityNotificationsRestApiTester extends ApiEndToEndTester
{
    use _generated\AvailabilityNotificationsRestApiTesterActions;

    /**
     * @param string $customerReference
     *
     * @return string
     */
    public function buildCustomerAvailabilityNotificationsUrl(string $customerReference): string
    {
        return $this->formatFullUrl(
            '{customers}/{customerReference}/{availabilityNotifications}',
            [
                'customers' => AvailabilityNotificationsRestApiConfig::RESOURCE_CUSTOMERS,
                'customerReference' => $customerReference,
                'availabilityNotifications' => AvailabilityNotificationsRestApiConfig::RESOURCE_AVAILABILITY_NOTIFICATIONS,
            ],
        );
    }
}
