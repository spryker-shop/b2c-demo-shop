<?php

namespace Pyz\Shared\ContentNavigationGui;

use Spryker\Shared\ContentNavigationGui\ContentNavigationGuiConfig as SprykerContentNavigationGuiConfig;

class ContentNavigationGuiConfig extends SprykerContentNavigationGuiConfig
{
    /**
     * Content item navigation list footer simple template name.
     */
    public const WIDGET_TEMPLATE_DISPLAY_NAME_LIST_FOOTER_SIMPLE = 'Footer Simple List';

    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_SIMPLE
     *
     * Content item navigation list footer simple template identifier.
     */
    public const WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_SIMPLE = 'list-footer-simple';

    /**
     * Content item navigation list footer icon template name.
     */
    public const WIDGET_TEMPLATE_DISPLAY_NAME_LIST_FOOTER_ICON = 'Footer Icon List';

    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_ICON
     *
     * Content item navigation list footer icon template identifier.
     */
    public const WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_ICON = 'list-footer-icon';

    /**
     * @api
     *
     * @return string[]
     */
    public function getContentWidgetTemplates(): array
    {
        $contentWidgetTemplates = parent::getContentWidgetTemplates();
        $contentWidgetTemplates += [
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_SIMPLE => static::WIDGET_TEMPLATE_DISPLAY_NAME_LIST_FOOTER_SIMPLE,
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_ICON => static::WIDGET_TEMPLATE_DISPLAY_NAME_LIST_FOOTER_ICON,
        ];

        return $contentWidgetTemplates;
    }
}
