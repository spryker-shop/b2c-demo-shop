<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ConfigurableBundleWidget;

use SprykerShop\Yves\ConfigurableBundleWidget\ConfigurableBundleWidgetConfig as SprykerConfigurableBundleWidgetConfig;

class ConfigurableBundleWidgetConfig extends SprykerConfigurableBundleWidgetConfig
{
    /**
     * @return bool
     */
    public function isQuantityChangeable(): bool
    {
        return true;
    }
}
