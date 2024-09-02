<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductAttribute;

use Spryker\Shared\ProductAttribute\ProductAttributeConfig as SprykerSharedProductAttributeConfig;
use Spryker\Zed\ProductAttribute\ProductAttributeConfig as SprykerProductAttributeConfig;

class ProductAttributeConfig extends SprykerProductAttributeConfig
{
    /**
     * @api
     *
     * @return array<string, string>
     */
    public function getAttributeAvailableTypes(): array
    {
        return array_merge(parent::getAttributeAvailableTypes(), [
            SprykerSharedProductAttributeConfig::INPUT_TYPE_MULTISELECT => SprykerSharedProductAttributeConfig::INPUT_TYPE_MULTISELECT,
        ]);
    }
}
