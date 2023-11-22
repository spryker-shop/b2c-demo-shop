<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PickingListPushNotification;

use Spryker\Zed\PickingListPushNotification\PickingListPushNotificationConfig as SprykerPickingListPushNotificationConfig;

class PickingListPushNotificationConfig extends SprykerPickingListPushNotificationConfig
{
    /**
     * @uses \Spryker\Zed\PushNotificationWebPushPhp\PushNotificationWebPushPhpConfig::WEB_PUSH_PHP_PROVIDER_NAME
     *
     * @var string
     */
    protected const PUSH_NOTIFICATION_PROVIDER_NAME = 'web-push-php';

    /**
     * @return string
     */
    public function getPushNotificationProviderName(): string
    {
        return static::PUSH_NOTIFICATION_PROVIDER_NAME;
    }
}
