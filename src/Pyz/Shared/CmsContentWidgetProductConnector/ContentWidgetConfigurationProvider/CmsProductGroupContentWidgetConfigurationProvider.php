<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider;

use SprykerShop\Shared\CmsContentWidgetProductConnector\ContentWidgetConfigurationProvider\CmsProductGroupContentWidgetConfigurationProvider as SprykerCmsProductGroupContentWidgetConfigurationProvider;

class CmsProductGroupContentWidgetConfigurationProvider extends SprykerCmsProductGroupContentWidgetConfigurationProvider
{
    /**
     * @var string
     */
    protected const SLIDER_TEMPLATE_IDENTIFIER = 'slider';

    /**
     * @return array<string, string>
     */
    public function getAvailableTemplates(): array
    {
        $availableTemplates = parent::getAvailableTemplates();
        $availableTemplates[static::SLIDER_TEMPLATE_IDENTIFIER] = '@CmsContentWidgetProductConnector/views/cms-product-group/cms-product-group-slider.twig';

        return $availableTemplates;
    }

    /**
     * @return string
     */
    public function getUsageInformation(): string
    {
        return "{{ product_group(['sku1', 'sku2']) }}, to use different template {{ product_group(['sku1', 'sku2'], 'default') }}";
    }
}
