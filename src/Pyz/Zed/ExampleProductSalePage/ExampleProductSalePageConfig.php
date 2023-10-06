<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage;

use Pyz\Shared\ExampleProductSalePage\ExampleProductSalePageConfig as SharedExampleProductSalePageConfig;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class ExampleProductSalePageConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getLabelSaleName(): string
    {
        return SharedExampleProductSalePageConfig::DEFAULT_LABEL_NAME;
    }
}
