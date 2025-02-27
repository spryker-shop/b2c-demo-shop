<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Shared\ContentBannerGui;

use Spryker\Shared\ContentBannerGui\ContentBannerGuiConfig as SprykerContentBannerGuiConfig;

class ContentBannerGuiConfig extends SprykerContentBannerGuiConfig
{
    /**
     * @var string
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITHOUT_LINK = 'slider-without-link';

    /**
     * @var string
     */
    protected const WIDGET_TEMPLATE_IDENTIFIER_SLIDER = 'slider';

    /**
     * Content item banner default template name
     *
     * @var string
     */
    protected const WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER = 'content_banner.template.slider';

    /**
     * Content item banner top-title template name
     *
     * @var string
     */
    protected const WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER_WITHOUT_LINK = 'content_banner.template.slider-without-link';

    /**
     * @return array<string, string>
     */
    public function getContentWidgetTemplates(): array
    {
        return array_merge(
            parent::getContentWidgetTemplates(),
            [
                static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER => static::WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER,
                static::WIDGET_TEMPLATE_IDENTIFIER_SLIDER_WITHOUT_LINK => static::WIDGET_TEMPLATE_DISPLAY_NAME_SLIDER_WITHOUT_LINK,
            ],
        );
    }
}
