<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Shared\ContentProductSetGui;

use Spryker\Shared\ContentProductSetGui\ContentProductSetGuiConfig as SprykerContentProductSetGuiConfig;

class ContentProductSetGuiConfig extends SprykerContentProductSetGuiConfig
{
    protected const WIDGET_TEMPLATE_IDENTIFIER_ADD_TO_CART = 'add-to-cart';

    /**
     * Content item banner default template name
     */
    protected const WIDGET_TEMPLATE_DISPLAY_NAME_ADD_TO_CART = 'content_product_set.template.add_to_cart';

    /**
     * @return array
     */
    public function getContentWidgetTemplates(): array
    {
        return array_merge(
            parent::getContentWidgetTemplates(),
            [
                static::WIDGET_TEMPLATE_IDENTIFIER_ADD_TO_CART => static::WIDGET_TEMPLATE_DISPLAY_NAME_ADD_TO_CART,
            ]
        );
    }
}
