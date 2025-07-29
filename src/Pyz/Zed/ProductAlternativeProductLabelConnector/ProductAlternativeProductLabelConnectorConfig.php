<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ProductAlternativeProductLabelConnector;

use Spryker\Zed\ProductAlternativeProductLabelConnector\ProductAlternativeProductLabelConnectorConfig as SprykerProductAlternativeProductLabelConnectorConfig;

class ProductAlternativeProductLabelConnectorConfig extends SprykerProductAlternativeProductLabelConnectorConfig
{
    /**
     * @var int
     */
    protected const PRODUCT_LABEL_DEFAULT_POSITION = 5;
}
