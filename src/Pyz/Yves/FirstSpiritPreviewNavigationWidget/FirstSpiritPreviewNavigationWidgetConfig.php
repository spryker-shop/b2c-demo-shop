<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\FirstSpiritPreviewNavigationWidget;

use ESpirit\Yves\FirstSpiritPreviewNavigationWidget\FirstSpiritPreviewNavigationWidgetConfig as ContentNavigationWidget;

class FirstSpiritPreviewNavigationWidgetConfig extends ContentNavigationWidget
{
    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER = 'navigation-header';

    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER_MOBILE
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER_MOBILE = 'navigation-header-mobile';

    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_FOOTER
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_FOOTER = 'navigation-footer';

    /**
     * @api
     *
     * @return string[]
     */
    public function getAvailableTemplateList(): array
    {
        $availableTemplates = parent::getAvailableTemplateList();
        $availableTemplates += [
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER => '@FirstSpiritPreviewNavigationWidget/views/navigation-header/navigation-header.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_HEADER_MOBILE => '@FirstSpiritPreviewNavigationWidget/views/navigation-header-mobile/navigation-header-mobile.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_NAVIGATION_FOOTER => '@FirstSpiritPreviewNavigationWidget/views/navigation-footer/navigation-footer.twig',
        ];

        return $availableTemplates;
    }
}
