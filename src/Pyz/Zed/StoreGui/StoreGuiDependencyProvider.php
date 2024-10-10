<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\StoreGui;

use Spryker\Zed\CountryGui\Communication\Plugin\StoreGui\AssignedCountriesStoreViewExpanderPlugin;
use Spryker\Zed\CountryGui\Communication\Plugin\StoreGui\CountryStoreFormExpanderPlugin;
use Spryker\Zed\CountryGui\Communication\Plugin\StoreGui\CountryStoreFormTabExpanderPlugin;
use Spryker\Zed\CountryGui\Communication\Plugin\StoreGui\CountryStoreFormViewExpanderPlugin;
use Spryker\Zed\CountryGui\Communication\Plugin\StoreGui\CountryStoreTableExpanderPlugin;
use Spryker\Zed\CurrencyGui\Communication\Plugin\StoreGui\AssignedCurrenciesStoreViewExpanderPlugin;
use Spryker\Zed\CurrencyGui\Communication\Plugin\StoreGui\CurrencyStoreFormExpanderPlugin;
use Spryker\Zed\CurrencyGui\Communication\Plugin\StoreGui\CurrencyStoreFormTabExpanderPlugin;
use Spryker\Zed\CurrencyGui\Communication\Plugin\StoreGui\CurrencyStoreFormViewExpanderPlugin;
use Spryker\Zed\CurrencyGui\Communication\Plugin\StoreGui\CurrencyStoreTableExpanderPlugin;
use Spryker\Zed\LocaleGui\Communication\Plugin\StoreGui\AssignedLocalesStoreViewExpanderPlugin;
use Spryker\Zed\LocaleGui\Communication\Plugin\StoreGui\DefaultLocaleStoreViewExpanderPlugin;
use Spryker\Zed\LocaleGui\Communication\Plugin\StoreGui\LocaleStoreFormExpanderPlugin;
use Spryker\Zed\LocaleGui\Communication\Plugin\StoreGui\LocaleStoreFormTabExpanderPlugin;
use Spryker\Zed\LocaleGui\Communication\Plugin\StoreGui\LocaleStoreFormViewExpanderPlugin;
use Spryker\Zed\LocaleGui\Communication\Plugin\StoreGui\LocaleStoreTableExpanderPlugin;
use Spryker\Zed\StoreContextGui\Communication\Plugin\StoreGui\ContextStoreFormExpanderPlugin;
use Spryker\Zed\StoreContextGui\Communication\Plugin\StoreGui\ContextStoreFormTabExpanderPlugin;
use Spryker\Zed\StoreGui\StoreGuiDependencyProvider as SprykerStoreGuiDependencyProvider;

class StoreGuiDependencyProvider extends SprykerStoreGuiDependencyProvider
{
    /**
     * @return array<\Spryker\Zed\StoreGuiExtension\Dependency\Plugin\StoreFormExpanderPluginInterface>
     */
    protected function getStoreFormExpanderPlugins(): array
    {
        return [
            new LocaleStoreFormExpanderPlugin(),
            new CurrencyStoreFormExpanderPlugin(),
            new CountryStoreFormExpanderPlugin(),
            new ContextStoreFormExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\StoreGuiExtension\Dependency\Plugin\StoreFormViewExpanderPluginInterface>
     */
    protected function getStoreFormViewExpanderPlugins(): array
    {
        return [
            new LocaleStoreFormViewExpanderPlugin(),
            new CurrencyStoreFormViewExpanderPlugin(),
            new CountryStoreFormViewExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\StoreGuiExtension\Dependency\Plugin\StoreFormTabExpanderPluginInterface>
     */
    protected function getStoreFormTabsExpanderPlugins(): array
    {
        return [
            new LocaleStoreFormTabExpanderPlugin(),
            new CurrencyStoreFormTabExpanderPlugin(),
            new CountryStoreFormTabExpanderPlugin(),
            new ContextStoreFormTabExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\StoreGuiExtension\Dependency\Plugin\StoreViewExpanderPluginInterface>
     */
    protected function getStoreViewExpanderPlugins(): array
    {
        return [
            new DefaultLocaleStoreViewExpanderPlugin(),
            new AssignedLocalesStoreViewExpanderPlugin(),
            new AssignedCurrenciesStoreViewExpanderPlugin(),
            new AssignedCountriesStoreViewExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\StoreGuiExtension\Dependency\Plugin\StoreTableExpanderPluginInterface>
     */
    protected function getStoreTableExpanderPlugins(): array
    {
        return [
            new LocaleStoreTableExpanderPlugin(),
            new CurrencyStoreTableExpanderPlugin(),
            new CountryStoreTableExpanderPlugin(),
        ];
    }
}
