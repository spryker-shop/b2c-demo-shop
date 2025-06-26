<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\PickingList;

use Spryker\Zed\PickingList\PickingListDependencyProvider as SprykerPickingListDependencyProvider;
use Spryker\Zed\PickingListMultiShipmentPickingStrategyExample\Communication\Plugin\PickingList\MultiShipmentPickingListGeneratorStrategyPlugin;
use Spryker\Zed\PickingListPushNotification\Communication\Plugin\PickingList\PushNotificationPickingListPostCreatePlugin;
use Spryker\Zed\PickingListPushNotification\Communication\Plugin\PickingList\PushNotificationPickingListPostUpdatePlugin;

class PickingListDependencyProvider extends SprykerPickingListDependencyProvider
{
    /**
     * @return list<\Spryker\Zed\PickingListExtension\Dependency\Plugin\PickingListPostCreatePluginInterface>
     */
    protected function getPickingListPostCreatePlugins(): array
    {
        return [
            new PushNotificationPickingListPostCreatePlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\PickingListExtension\Dependency\Plugin\PickingListPostUpdatePluginInterface>
     */
    protected function getPickingListPostUpdatePlugins(): array
    {
        return [
            new PushNotificationPickingListPostUpdatePlugin(),
        ];
    }

    /**
     * @return list<\Spryker\Zed\PickingListExtension\Dependency\Plugin\PickingListGeneratorStrategyPluginInterface>
     */
    protected function getPickingListGeneratorStrategyPlugins(): array
    {
        return [
            new MultiShipmentPickingListGeneratorStrategyPlugin(),
        ];
    }
}
