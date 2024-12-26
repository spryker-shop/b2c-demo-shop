<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\StorageRouter;

use Spryker\Client\Kernel\Container;
use SprykerShop\Yves\StorageRouter\StorageRouterConfig as SprykerStorageRouterConfig;

class StorageRouterConfig extends SprykerStorageRouterConfig
{
    /**
     * @return array<string>
     */
    public function getAllowedStores(): array
    {
        return (new Container())->getLocator()->storeStorage()->client()->getStoreNames();
    }
}
