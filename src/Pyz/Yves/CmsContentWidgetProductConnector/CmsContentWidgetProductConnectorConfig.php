<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CmsContentWidgetProductConnector;

use Spryker\Yves\CmsContentWidgetProductConnector\CmsContentWidgetProductConnectorConfig as SprykerCmsContentWidgetProductConnectorConfig;

class CmsContentWidgetProductConnectorConfig extends SprykerCmsContentWidgetProductConnectorConfig
{
    /**
     * @return bool
     */
    public function isUnavailableProductsDisplayed(): bool
    {
        return true;
    }
}
