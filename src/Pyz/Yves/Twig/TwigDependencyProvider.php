<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\Twig;

use Spryker\Service\UtilDateTime\Plugin\Twig\DateTimeFormatterTwigPlugin;
use Spryker\Shared\Twig\Plugin\DebugTwigPlugin;
use Spryker\Shared\Twig\Plugin\FormTwigPlugin;
use Spryker\Shared\Twig\Plugin\RoutingTwigPlugin;
use Spryker\Shared\Twig\Plugin\SecurityTwigPlugin;
use Spryker\Yves\CmsContentWidget\Plugin\Twig\CmsContentWidgetTwigPlugin;
use Spryker\Yves\Http\Plugin\Twig\HttpKernelTwigPlugin;
use Spryker\Yves\Http\Plugin\Twig\RuntimeLoaderTwigPlugin;
use Spryker\Yves\Translator\Plugin\Twig\TranslatorTwigPlugin;
use Spryker\Yves\Twig\Plugin\FilesystemTwigLoaderPlugin;
use Spryker\Yves\Twig\Plugin\FormFilesystemTwigLoaderPlugin;
use Spryker\Yves\Twig\TwigDependencyProvider as SprykerTwigDependencyProvider;
use SprykerShop\Yves\CartPage\Plugin\Twig\CartTwigPlugin;
use SprykerShop\Yves\CatalogPage\Plugin\Twig\CatalogPageTwigPlugin;
use SprykerShop\Yves\CategoryWidget\Plugin\Twig\CategoryTwigPlugin;
use SprykerShop\Yves\ChartWidget\Plugin\Twig\ChartTwigPlugin;
use SprykerShop\Yves\CmsBlockWidget\Plugin\Twig\CmsBlockTwigPlugin;
use SprykerShop\Yves\CmsPage\Plugin\Twig\CmsTwigPlugin;
use SprykerShop\Yves\ContentBannerWidget\Plugin\Twig\ContentBannerTwigPlugin;
use SprykerShop\Yves\ContentFileWidget\Plugin\Twig\ContentFileListTwigPlugin;
use SprykerShop\Yves\ContentNavigationWidget\Plugin\Twig\ContentNavigationTwigPlugin;
use SprykerShop\Yves\ContentProductSetWidget\Plugin\Twig\ContentProductSetTwigPlugin;
use SprykerShop\Yves\ContentProductWidget\Plugin\Twig\ContentProductAbstractListTwigPlugin;
use SprykerShop\Yves\CustomerPage\Plugin\Twig\CustomerTwigPlugin;
use SprykerShop\Yves\MoneyWidget\Plugin\Twig\MoneyTwigPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\Twig\ShopApplicationFormTwigLoaderPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\Twig\ShopApplicationTwigPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\Twig\WidgetTagTwigPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\Twig\WidgetTwigPlugin;
use SprykerShop\Yves\ShopApplication\Plugin\TwigFormRuntimeLoaderPlugin;
use SprykerShop\Yves\ShopCmsSlot\Plugin\Twig\ShopCmsSlotTwigPlugin;
use SprykerShop\Yves\ShopPermission\Plugin\Twig\ShopPermissionTwigPlugin;
use SprykerShop\Yves\ShopUi\Plugin\Twig\FunctionTwigPlugin;
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
            new TranslatorTwigPlugin(),
            new RuntimeLoaderTwigPlugin(),
            new ShopApplicationTwigPlugin(),
            new TwigFormRuntimeLoaderPlugin(),
            new ChartTwigPlugin(),
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
            new ContentProductSetTwigPlugin(),
            new ContentFileListTwigPlugin(),
            new FunctionTwigPlugin(),
            new ShopCmsSlotTwigPlugin(),
            new ContentNavigationTwigPlugin(),
        ];
    }

    /**
     * @return \Spryker\Shared\TwigExtension\Dependency\Plugin\TwigLoaderPluginInterface[]
     */
    protected function getTwigLoaderPlugins(): array
    {
        $plugins = [
            new FilesystemTwigLoaderPlugin(),
            new FormFilesystemTwigLoaderPlugin(),
            new ShopApplicationFormTwigLoaderPlugin(),
        ];

        if (class_exists(WebProfilerTwigLoaderPlugin::class)) {
            $plugins[] = new WebProfilerTwigLoaderPlugin();
        }

        return $plugins;
    }
}
