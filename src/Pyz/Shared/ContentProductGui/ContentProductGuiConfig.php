<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Shared\ContentProductGui;

use Spryker\Shared\ContentProductGui\ContentProductGuiConfig as SprykerContentProductGuiConfig;

class ContentProductGuiConfig extends SprykerContentProductGuiConfig
{
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER = 'slider';
    protected const WIDGET_TEMPLATE_IDENTIFIER_WITH_BUTTON = 'slider-with-button';
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER_NOT_INCLUDE_GROUP = 'slider-not-include-group';
    /**
     * Content item banner default template name
     */
    protected const WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER = 'content_product.template.slider';

    /**
     * Content item banner default template name
     */
    protected const WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER_WITH_BUTTON = 'content_product.template.slider_with_button';

    /**
     * Content item banner default template name
     */
    protected const WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER_NOT_INCLUDE_GROUP = 'content_product.template.slider_not_include_group';

    /**
     * @return array
     */
    public function getContentWidgetTemplates(): array
    {
        return array_merge(
            parent::getContentWidgetTemplates(),
            [
                static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER => static::WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER,
                static::WIDGET_TEMPLATE_IDENTIFIER_WITH_BUTTON => static::WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER_WITH_BUTTON,
                static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER_NOT_INCLUDE_GROUP => static::WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER_NOT_INCLUDE_GROUP,
            ]
        );
    }
}
