<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Transfer;

use Spryker\Zed\Transfer\TransferConfig as SprykerTransferConfig;

class TransferConfig extends SprykerTransferConfig
{
    /**
     * @return array
     */
    public function getEntitiesSourceDirectories()
    {
        return [
            APPLICATION_SOURCE_DIR . '/Orm/Propel/*/Schema/',
        ];
    }

    protected function getCoreSourceDirectoryGlobPatterns()
    {
        return [
            APPLICATION_VENDOR_DIR . '/*/*/src/*/Shared/*/Transfer/',
            APPLICATION_VENDOR_DIR . '/spryker/spryker/Bundles/CmsSlot*/src/Spryker/Shared/*/Transfer/',
            APPLICATION_VENDOR_DIR . '/spryker/spryker-shop/Bundles/ShopCmsSlot*/src/SprykerShop/Shared/*/Transfer/',
        ];
    }
}
