<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CmsContentWidgetProductSetConnector;

use SprykerShop\Yves\CmsContentWidgetProductSetConnector\CmsContentWidgetProductSetConnectorDependencyProvider as SprykerShopCmsContentWidgetProductSetConnectorDependencyProvider;
use SprykerShop\Yves\ProductSetWidget\Plugin\CmsContentWidgetProductSetConnector\ProductSetWidgetPlugin;

class CmsContentWidgetProductSetConnectorDependencyProvider extends SprykerShopCmsContentWidgetProductSetConnectorDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getCmsProductSetContentWidgetPlugins(): array
    {
        return [
            ProductSetWidgetPlugin::class,
        ];
    }
}
