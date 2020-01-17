<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ConfigurableBundleGui;

use Spryker\Zed\ConfigurableBundleGui\ConfigurableBundleGuiDependencyProvider as SprykerConfigurableBundleGuiDependencyProvider;
use Spryker\Zed\ProductListGui\Communication\Plugin\ConfigurableBundleGui\ProductConcreteRelationConfigurableBundleTemplateSlotEditSubTabsProviderPlugin;
use Spryker\Zed\ProductListGui\Communication\Plugin\ConfigurableBundleGui\ProductConcreteRelationConfigurableBundleTemplateSlotEditTablesProviderPlugin;
use Spryker\Zed\ProductListGui\Communication\Plugin\ConfigurableBundleGui\ProductConcreteRelationCsvConfigurableBundleTemplateSlotEditFormFileUploadHandlerPlugin;
use Spryker\Zed\ProductListGui\Communication\Plugin\ConfigurableBundleGui\ProductListManagementConfigurableBundleTemplateSlotEditFormDataProviderExpanderPlugin;
use Spryker\Zed\ProductListGui\Communication\Plugin\ConfigurableBundleGui\ProductListManagementConfigurableBundleTemplateSlotEditFormExpanderPlugin;
use Spryker\Zed\ProductListGui\Communication\Plugin\ConfigurableBundleGui\ProductListManagementConfigurableBundleTemplateSlotEditTabsExpanderPlugin;

class ConfigurableBundleGuiDependencyProvider extends SprykerConfigurableBundleGuiDependencyProvider
{
    /**
     * @return \Spryker\Zed\ConfigurableBundleGuiExtension\Dependency\Plugin\ConfigurableBundleTemplateSlotEditTabsExpanderPluginInterface[]
     */
    protected function getConfigurableBundleTemplateSlotEditTabsExpanderPlugins(): array
    {
        return [
            new ProductListManagementConfigurableBundleTemplateSlotEditTabsExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ConfigurableBundleGuiExtension\Dependency\Plugin\ConfigurableBundleTemplateSlotEditFormExpanderPluginInterface[]
     */
    protected function getConfigurableBundleTemplateSlotEditFormExpanderPlugins(): array
    {
        return [
            new ProductListManagementConfigurableBundleTemplateSlotEditFormExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ConfigurableBundleGuiExtension\Dependency\Plugin\ConfigurableBundleTemplateSlotEditFormDataProviderExpanderPluginInterface[]
     */
    protected function getConfigurableBundleTemplateSlotEditFormDataProviderExpanderPlugins(): array
    {
        return [
            new ProductListManagementConfigurableBundleTemplateSlotEditFormDataProviderExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ConfigurableBundleGuiExtension\Dependency\Plugin\ConfigurableBundleTemplateSlotEditFormFileUploadHandlerPluginInterface[]
     */
    protected function getConfigurableBundleTemplateSlotEditFormFileUploadHandlerPlugins(): array
    {
        return [
            new ProductConcreteRelationCsvConfigurableBundleTemplateSlotEditFormFileUploadHandlerPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ConfigurableBundleGuiExtension\Dependency\Plugin\ConfigurableBundleTemplateSlotEditSubTabsProviderPluginInterface[]
     */
    protected function getConfigurableBundleTemplateSlotEditSubTabsProviderPlugins(): array
    {
        return [
            new ProductConcreteRelationConfigurableBundleTemplateSlotEditSubTabsProviderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ConfigurableBundleGuiExtension\Dependency\Plugin\ConfigurableBundleTemplateSlotEditTablesProviderPluginInterface[]
     */
    protected function getConfigurableBundleTemplateSlotEditTablesProviderPlugins(): array
    {
        return [
            new ProductConcreteRelationConfigurableBundleTemplateSlotEditTablesProviderPlugin(),
        ];
    }
}
