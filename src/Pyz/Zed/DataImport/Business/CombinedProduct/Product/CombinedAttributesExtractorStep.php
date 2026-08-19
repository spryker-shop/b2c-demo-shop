<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\CombinedProduct\Product;

use Pyz\Zed\DataImport\Business\Model\Product\AttributesExtractorStep;

class CombinedAttributesExtractorStep extends AttributesExtractorStep
{
    protected function getAttributeKeyPrefix(): string
    {
        return 'product.attribute_key_';
    }

    protected function getAttributeValuePrefix(): string
    {
        return 'product.value_';
    }
}
