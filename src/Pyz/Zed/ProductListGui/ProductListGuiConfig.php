<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductListGui;

use Spryker\Zed\ProductListGui\ProductListGuiConfig as SprykerProductListGuiConfig;

class ProductListGuiConfig extends SprykerProductListGuiConfig
{
    /**
     * @var bool
     */
    protected const IS_FILE_EXTENSION_VALIDATION_ENABLED = true;
}
