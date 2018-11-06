<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CmsContentWidget;

use Spryker\Yves\CmsContentWidget\CmsContentWidgetDependencyProvider as SprykerCmsContentWidgetDependencyProvider;
use SprykerShop\Shared\CmsContentWidgetChartConnector\ContentWidgetConfigurationProvider\CmsChartContentWidgetConfigurationProvider;
use SprykerShop\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider\CmsProductContentWidgetConfigurationProvider;
use SprykerShop\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider\CmsProductGroupContentWidgetConfigurationProvider;
use SprykerShop\Shared\CmsContentWidgetProductSetConnector\ContentWidgetConfigurationProvider\CmsProductSetContentWidgetConfigurationProvider;
use SprykerShop\Shared\FileManagerWidget\CmsContentWidgetConfigurationProvider\FileManagerWidgetConfigurationProvider;
use SprykerShop\Yves\CmsContentWidgetChartConnector\Plugin\CmsContentWidget\CmsChartContentWidgetPlugin;
use SprykerShop\Yves\CmsContentWidgetProductConnector\Plugin\CmsProductContentWidgetPlugin;
use SprykerShop\Yves\CmsContentWidgetProductSetConnector\Plugin\CmsProductSetContentWidgetPlugin;
use SprykerShop\Yves\FileManagerWidget\Plugin\CmsContentWidget\FileManagerWidgetPlugin;

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
            CmsChartContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsChartContentWidgetPlugin(
                new CmsChartContentWidgetConfigurationProvider()
            ),
            CmsProductContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsProductContentWidgetPlugin(
                new CmsProductContentWidgetConfigurationProvider()
            ),
            CmsProductGroupContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsProductContentWidgetPlugin(
                new CmsProductGroupContentWidgetConfigurationProvider()
            ),
            CmsProductSetContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsProductSetContentWidgetPlugin(
                new CmsProductSetContentWidgetConfigurationProvider()
            ),
            CmsChartContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsChartContentWidgetPlugin(
                new CmsChartContentWidgetConfigurationProvider()
            ),
            FileManagerWidgetConfigurationProvider::FUNCTION_NAME => new FileManagerWidgetPlugin(
                new FileManagerWidgetConfigurationProvider()
            ),
        ];
    }
}
