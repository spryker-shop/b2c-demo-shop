<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CmsContentWidget;

use Spryker\Yves\CmsContentWidget\CmsContentWidgetDependencyProvider as SprykerCmsContentWidgetDependencyProvider;
use SprykerShop\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider\CmsProductContentWidgetConfigurationProvider;
use SprykerShop\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider\CmsProductGroupContentWidgetConfigurationProvider;
use SprykerShop\Shared\CmsContentWidgetProductSetConnector\ContentWidgetConfigurationProvider\CmsProductSetContentWidgetConfigurationProvider;
use SprykerShop\Yves\CmsContentWidgetProductConnector\Plugin\CmsProductContentWidgetPlugin;
use SprykerShop\Yves\CmsContentWidgetProductSetConnector\Plugin\CmsProductSetContentWidgetPlugin;

class CmsContentWidgetDependencyProvider extends SprykerCmsContentWidgetDependencyProvider
{
    /**
     * {@inheritdoc}
     *
     * @return \Spryker\Yves\CmsContentWidget\Dependency\CmsContentWidgetPluginInterface[]
     */
    public function getCmsContentWidgetPlugins()
    {
        return [
            CmsProductContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsProductContentWidgetPlugin(
                new CmsProductContentWidgetConfigurationProvider()
            ),
            CmsProductGroupContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsProductContentWidgetPlugin(
                new CmsProductGroupContentWidgetConfigurationProvider()
            ),
            CmsProductSetContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsProductSetContentWidgetPlugin(
                new CmsProductSetContentWidgetConfigurationProvider()
            ),
        ];
    }
}
