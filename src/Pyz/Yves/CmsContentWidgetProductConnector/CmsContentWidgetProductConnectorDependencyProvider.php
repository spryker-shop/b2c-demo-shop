<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CmsContentWidgetProductConnector;

use SprykerShop\Yves\CmsContentWidgetProductConnector\CmsContentWidgetProductConnectorDependencyProvider as SprykerShopCmsContentWidgetProductConnectorDependencyProvider;
use SprykerShop\Yves\ProductWidget\Plugin\CmsContentWidget\ProductGroupWidgetPlugin;
use SprykerShop\Yves\ProductWidget\Plugin\CmsContentWidget\ProductWidgetPlugin;

class CmsContentWidgetProductConnectorDependencyProvider extends SprykerShopCmsContentWidgetProductConnectorDependencyProvider
{
    /**
     * @return string[]
     */
    protected function getCmsProductContentWidgetPlugins()
    {
        return [
            ProductWidgetPlugin::class,
            ProductGroupWidgetPlugin::class,
        ];
    }
}
