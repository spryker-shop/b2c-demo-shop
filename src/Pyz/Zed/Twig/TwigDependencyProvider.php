<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Twig;

use Spryker\Service\UtilDateTime\Plugin\Twig\DateTimeFormatterTwigPlugin;
use Spryker\Shared\Twig\Plugin\DebugTwigPlugin;
use Spryker\Shared\Twig\Plugin\FormTwigPlugin;
use Spryker\Shared\Twig\Plugin\HttpKernelTwigPlugin;
use Spryker\Shared\Twig\Plugin\RoutingTwigPlugin;
use Spryker\Shared\Twig\Plugin\RuntimeLoaderTwigPlugin;
use Spryker\Shared\Twig\Plugin\SecurityTwigPlugin;
use Spryker\Shared\Twig\Plugin\TranslationTwigPlugin;
use Spryker\Zed\Application\Communication\Plugin\Twig\ApplicationTwigPlugin;
use Spryker\Zed\Chart\Communication\Plugin\Twig\ChartTwigPlugin;
use Spryker\Zed\Currency\Communication\Plugin\Twig\CurrencyTwigPlugin;
use Spryker\Zed\Gui\Communication\Plugin\Twig\FormRuntimeLoaderTwigPlugin;
use Spryker\Zed\Gui\Communication\Plugin\Twig\GuiTwigLoaderPlugin;
use Spryker\Zed\Money\Communication\Plugin\Twig\MoneyTwigPlugin;
use Spryker\Zed\Scheduler\Communication\Plugin\Twig\SchedulerTwigPlugin;
use Spryker\Zed\Translator\Communication\Plugin\Twig\TranslatorTwigPlugin;
use Spryker\Zed\Twig\Communication\Plugin\FilesystemTwigLoaderPlugin;
use Spryker\Zed\Twig\Communication\Plugin\FormFilesystemTwigLoaderPlugin;
use Spryker\Zed\Twig\TwigDependencyProvider as SprykerTwigDependencyProvider;
use Spryker\Zed\User\Communication\Plugin\Twig\UserTwigPlugin;
use Spryker\Zed\WebProfiler\Communication\Plugin\Twig\WebProfilerTwigLoaderPlugin;
use Spryker\Zed\ZedNavigation\Communication\Plugin\Twig\ZedNavigationTwigPlugin;

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
            new FormRuntimeLoaderTwigPlugin(),
            new ApplicationTwigPlugin(),
            new ChartTwigPlugin(),
            new UserTwigPlugin(),
            new MoneyTwigPlugin(),
            new CurrencyTwigPlugin(),
            new ZedNavigationTwigPlugin(),
            new TranslatorTwigPlugin(),
            new DateTimeFormatterTwigPlugin(),
            new SchedulerTwigPlugin(),
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
            new WebProfilerTwigLoaderPlugin(),
            new GuiTwigLoaderPlugin(),
        ];
    }
}
