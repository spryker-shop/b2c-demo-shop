<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider;

use SprykerShop\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider\CmsProductGroupContentWidgetConfigurationProvider as SprykerCmsProductGroupContentWidgetConfigurationProvider;

class CmsProductGroupContentWidgetConfigurationProvider extends SprykerCmsProductGroupContentWidgetConfigurationProvider
{
    const SLIDER_TEMPLATE_IDENTIFIER = 'slider';

    /**
     * @return array
     */
    public function getAvailableTemplates()
    {
        $availableTemplates = parent::getAvailableTemplates();
        $availableTemplates[self::SLIDER_TEMPLATE_IDENTIFIER] = '@CmsContentWidgetProductConnector/views/cms-product-group/cms-product-group-slider.twig';

        return $availableTemplates;
    }

    /**
     * @return string
     */
    public function getUsageInformation()
    {
        return "{{ product_group(['sku1', 'sku2']) }}, to use different template {{ product_group(['sku1', 'sku2'], 'default') }}";
    }
}
