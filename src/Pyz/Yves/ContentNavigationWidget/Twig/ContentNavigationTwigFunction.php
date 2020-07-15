<?php

namespace Pyz\Yves\ContentBannerWidget\Twig;

use SprykerShop\Yves\ContentNavigationWidget\Twig\ContentNavigationTwigFunction as SprykerShopContentNavigationTwigFunction;

class ContentNavigationTwigFunction extends SprykerShopContentNavigationTwigFunction
{
    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_SIMPLE = 'list-footer-simple';

    /**
     * @uses \Pyz\Shared\ContentNavigation\ContentNavigationConfig::WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_ICON
     */
    public const WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_ICON = 'list-footer-icon';

    /**
     * @param string $templateIdentifier
     *
     * @return string|null
     */
    protected function findTemplate(string $templateIdentifier): ?string
    {
        $availableTemplates = [
            static::WIDGET_TEMPLATE_IDENTIFIER_TREE_INLINE => '@ContentNavigationWidget/views/navigation/tree-inline.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_TREE => '@ContentNavigationWidget/views/navigation/tree.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_INLINE => '@ContentNavigationWidget/views/navigation/list-inline.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST => '@ContentNavigationWidget/views/navigation/list.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_SIMPLE => '@ContentNavigationWidget/views/navigation/list-footer-simple.twig',
            static::WIDGET_TEMPLATE_IDENTIFIER_LIST_FOOTER_ICON => '@ContentNavigationWidget/views/navigation/list-footer-icon.twig',
        ];

        return $availableTemplates[$templateIdentifier] ?? null;
    }
}
