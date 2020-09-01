<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Shared\ContentNavigationGui;

use Spryker\Shared\ContentNavigationGui\ContentNavigationGuiConfig as SprykerContentNavigationGuiConfig;

class ContentNavigationGuiConfig extends SprykerContentNavigationGuiConfig
{
    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER
     *
     * Content item navigation header template identifier.
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER = 'navigation-header';

    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER_MOBILE
     *
     * Content item navigation header mobile template identifier.
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER_MOBILE = 'navigation-header-mobile';

    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_FOOTER
     *
     * Content item navigation footer template identifier.
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_FOOTER = 'navigation-footer';

    /**
     * Content item navigation header template name.
     */
    protected const WIDGET_TEMPLATE_DISPLAY_NAME_LIST_NAVIGATION_HEADER = 'Navigation Header';

    /**
     * Content item navigation header mobile template name.
     */
    protected const WIDGET_TEMPLATE_DISPLAY_NAME_LIST_NAVIGATION_HEADER_MOBILE = 'Navigation Header Mobile';

    /**
     * Content item navigation footer template name.
     */
    protected const WIDGET_TEMPLATE_DISPLAY_NAME_LIST_NAVIGATION_FOOTER = 'Navigation Footer';

    /**
     * @api
     *
     * @return string[]
     */
    public function getContentWidgetTemplates(): array
    {
        $contentWidgetTemplates = parent::getContentWidgetTemplates();
        $contentWidgetTemplates += [
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER => static::WIDGET_TEMPLATE_DISPLAY_NAME_LIST_NAVIGATION_HEADER,
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER_MOBILE => static::WIDGET_TEMPLATE_DISPLAY_NAME_LIST_NAVIGATION_HEADER_MOBILE,
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_FOOTER => static::WIDGET_TEMPLATE_DISPLAY_NAME_LIST_NAVIGATION_FOOTER,
        ];

        return $contentWidgetTemplates;
    }
}
