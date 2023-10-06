<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsContentWidget;

use Spryker\Shared\CmsContentWidgetCmsBlockConnector\ContentWidgetConfigurationProvider\CmsContentWidgetCmsBlockConnectorConfigurationProvider;
use Spryker\Zed\CmsContentWidget\CmsContentWidgetConfig as SprykerCmsContentConfig;
use SprykerShop\Shared\CmsContentWidgetChartConnector\ContentWidgetConfigurationProvider\CmsChartContentWidgetConfigurationProvider;
use SprykerShop\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider\CmsProductContentWidgetConfigurationProvider;
use SprykerShop\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider\CmsProductGroupContentWidgetConfigurationProvider;
use SprykerShop\Shared\CmsContentWidgetProductSetConnector\ContentWidgetConfigurationProvider\CmsProductSetContentWidgetConfigurationProvider;
use SprykerShop\Shared\FileManagerWidget\CmsContentWidgetConfigurationProvider\FileManagerWidgetConfigurationProvider;

class CmsContentWidgetConfig extends SprykerCmsContentConfig
{
    /**
     * {@inheritDoc}
     *
     * @return array<\Spryker\Shared\CmsContentWidget\Dependency\CmsContentWidgetConfigurationProviderInterface>
     */
    public function getCmsContentWidgetConfigurationProviders()
    {
        return [
            CmsChartContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsChartContentWidgetConfigurationProvider(),
            CmsProductContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsProductContentWidgetConfigurationProvider(),
            CmsProductSetContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsProductSetContentWidgetConfigurationProvider(),
            CmsProductGroupContentWidgetConfigurationProvider::FUNCTION_NAME => new CmsProductGroupContentWidgetConfigurationProvider(),
            FileManagerWidgetConfigurationProvider::FUNCTION_NAME => new FileManagerWidgetConfigurationProvider(),
            CmsContentWidgetCmsBlockConnectorConfigurationProvider::FUNCTION_NAME => new CmsContentWidgetCmsBlockConnectorConfigurationProvider(),
        ];
    }
}
