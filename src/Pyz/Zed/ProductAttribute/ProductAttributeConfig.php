<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductAttribute;

use Spryker\Shared\ProductAttribute\ProductAttributeConfig as SharedProductAttributeConfig;
use Spryker\Zed\ProductAttribute\ProductAttributeConfig as SprykerProductAttributeConfig;

class ProductAttributeConfig extends SprykerProductAttributeConfig
{
    /**
     * @return array<string, string>
     */
    public function getAttributeAvailableTypes(): array
    {
        return array_merge(
            parent::getAttributeAvailableTypes(),
            [
                SharedProductAttributeConfig::INPUT_TYPE_MULTISELECT => SharedProductAttributeConfig::INPUT_TYPE_MULTISELECT,
            ],
        );
    }
}
