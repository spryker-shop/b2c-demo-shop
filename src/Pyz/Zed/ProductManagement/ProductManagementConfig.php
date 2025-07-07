<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductManagement;

use Spryker\Zed\ProductManagement\ProductManagementConfig as SprykerProductManagementConfig;

class ProductManagementConfig extends SprykerProductManagementConfig
{
    /**
     * @return bool
     */
    public function isConcreteSkuSearchInProductTableEnabled(): bool
    {
        return true;
    }
}
