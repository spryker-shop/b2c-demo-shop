<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Locale;

use Spryker\Shared\LocaleExtension\Dependency\Plugin\LocalePluginInterface;
use Spryker\Zed\Locale\LocaleDependencyProvider as SprykerLocaleDependencyProvider;
use Spryker\Zed\UserLocale\Communication\Plugin\Locale\UserLocaleLocalePlugin;

class LocaleDependencyProvider extends SprykerLocaleDependencyProvider
{
    /**
     * @return \Spryker\Shared\LocaleExtension\Dependency\Plugin\LocalePluginInterface
     */
    protected function getLocalePlugin(): LocalePluginInterface
    {
        return new UserLocaleLocalePlugin();
    }
}
