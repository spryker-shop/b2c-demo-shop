<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\CmsSlot;

use Spryker\Client\CmsSlot\CmsSlotDependencyProvider as SprykerCmsSlotDependencyProvider;
use Spryker\Client\CmsSlotLocaleConnector\Plugin\CmsSlot\LocaleExternalDataProviderStrategyPlugin;
use Spryker\Client\CmsSlotStoreConnector\Plugin\CmsSlot\StoreExternalDataProviderStrategyPlugin;

class CmsSlotDependencyProvider extends SprykerCmsSlotDependencyProvider
{
    /**
     * @return \Spryker\Client\CmsSlotExtension\Dependency\Plugin\ExternalDataProviderStrategyPluginInterface[]
     */
    public function getExternalDataProviderStrategyPlugins(): array
    {
        return [
            new LocaleExternalDataProviderStrategyPlugin(),
            new StoreExternalDataProviderStrategyPlugin(),
        ];
    }
}
