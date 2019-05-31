<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Twig;

use Spryker\Service\UtilDateTime\Plugin\Twig\DateTimeFormatterTwigPlugin;
use Spryker\Shared\Twig\Plugin\DebugTwigPlugin;
use Spryker\Shared\Twig\Plugin\FormTwigPlugin;
use Spryker\Shared\Twig\Plugin\HttpKernelTwigPlugin;
use Spryker\Shared\Twig\Plugin\RoutingTwigPlugin;
use Spryker\Shared\Twig\Plugin\RuntimeLoaderTwigPlugin;
use Spryker\Shared\Twig\Plugin\SecurityTwigPlugin;
use Spryker\Shared\Twig\Plugin\TranslationTwigPlugin;
use Spryker\Yves\CmsContentWidget\Plugin\Twig\CmsContentWidgetTwigPlugin;
use Spryker\Yves\Twig\Plugin\FilesystemTwigLoaderPlugin;
use Spryker\Yves\Twig\Plugin\FormFilesystemTwigLoaderPlugin;
use Spryker\Yves\Twig\TwigDependencyProvider as SprykerTwigDependencyProvider;
use SprykerShop\Yves\CartPage\Plugin\Twig\CartTwigPlugin;
use SprykerShop\Yves\CatalogPage\Plugin\Twig\CatalogPageTwigPlugin;
use SprykerShop\Yves\CategoryWidget\Plugin\Twig\CategoryTwigPlugin;
use SprykerShop\Yves\CmsBlockWidget\Plugin\Twig\CmsBlockTwigPlugin;
use SprykerShop\Yves\CmsPage\Plugin\Twig\CmsTwigPlugin;
use SprykerShop\Yves\ContentBannerWidget\Plugin\Twig\ContentBannerTwigPlugin;
use SprykerShop\Yves\ContentProductWidget\Plugin\Twig\ContentProductAbstractListTwigPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\Twig\CustomerTwigPlugin;
use SprykerShop\Yves\MoneyWidget\Plugin\Twig\MoneyTwigPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\Twig\ShopApplicationFormTwigLoaderPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\Twig\ShopApplicationTwigPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\Twig\WidgetTagTwigPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\Twig\WidgetTwigPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\TwigFormRuntimeLoaderPlugin;
use SprykerShop\Yves\ShopPermission\Plugin\Twig\ShopPermissionTwigPlugin;
use SprykerShop\Yves\ShopUi\Plugin\Twig\ShopUiTwigPlugin;
use SprykerShop\Yves\WebProfilerWidget\Plugin\Twig\WebProfilerTwigLoaderPlugin;

/**
 * @method \Spryker\Yves\Twig\TwigConfig getConfig()
 */
class TwigDependencyProvider extends SprykerTwigDependencyProvider
{
    /**
     * @return \Spryker\Shared\TwigExtension\Dependency\Plugin\TwigPluginInterface[]
     */
    protected function getTwigPlugins(): array
    {
        return [
            new DebugTwigPlugin(),
            new FormTwigPlugin(),
            new HttpKernelTwigPlugin(),
            new RoutingTwigPlugin(),
            new SecurityTwigPlugin(),
            new TranslationTwigPlugin(),
            new RuntimeLoaderTwigPlugin(),
            new ShopApplicationTwigPlugin(),
            new TwigFormRuntimeLoaderPlugin(),
            new CatalogPageTwigPlugin(),
            new CmsBlockTwigPlugin(),
            new MoneyTwigPlugin(),
            new WidgetTwigPlugin(),
            new CartTwigPlugin(),
            new ShopPermissionTwigPlugin(),
            new CmsContentWidgetTwigPlugin(),
            new CmsTwigPlugin(),
            new ShopUiTwigPlugin(),
            new CategoryTwigPlugin(),
            new DateTimeFormatterTwigPlugin(),
            new CustomerTwigPlugin(),
            new WidgetTagTwigPlugin(),
            new ContentBannerTwigPlugin(),
            new ContentProductAbstractListTwigPlugin(),
        ];
    }

    /**
     * @return \Spryker\Shared\TwigExtension\Dependency\Plugin\TwigLoaderPluginInterface[]
     */
    protected function getTwigLoaderPlugins(): array
    {
        return [
            new FilesystemTwigLoaderPlugin(),
            new FormFilesystemTwigLoaderPlugin(),
            new ShopApplicationFormTwigLoaderPlugin(),
            new WebProfilerTwigLoaderPlugin(),
        ];
    }
}
