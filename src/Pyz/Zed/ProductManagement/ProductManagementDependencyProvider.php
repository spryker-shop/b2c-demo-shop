<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductManagement;

use Spryker\Zed\CmsBlockProductConnector\Communication\Plugin\CmsBlockProductAbstractBlockListViewPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Money\Communication\Plugin\Form\MoneyFormTypePlugin;
use Spryker\Zed\ProductAlternativeGui\Communication\Plugin\ProductManagement\ProductConcreteEditFormExpanderPlugin;
use Spryker\Zed\ProductAlternativeGui\Communication\Plugin\ProductManagement\ProductConcreteFormEditDataProviderExpanderPlugin;
use Spryker\Zed\ProductAlternativeGui\Communication\Plugin\ProductManagement\ProductConcreteFormEditTabsExpanderPlugin;
use Spryker\Zed\ProductAlternativeGui\Communication\Plugin\ProductManagement\ProductFormTransferMapperExpanderPlugin;
use Spryker\Zed\ProductDiscontinuedGui\Communication\Plugin\DiscontinuedNotesProductFormTransferMapperExpanderPlugin;
use Spryker\Zed\ProductDiscontinuedGui\Communication\Plugin\DiscontinuedProductConcreteEditFormExpanderPlugin;
use Spryker\Zed\ProductDiscontinuedGui\Communication\Plugin\DiscontinueProductConcreteFormEditDataProviderExpanderPlugin;
use Spryker\Zed\ProductDiscontinuedGui\Communication\Plugin\DiscontinueProductConcreteFormEditTabsExpanderPlugin;
use Spryker\Zed\ProductManagement\ProductManagementDependencyProvider as SprykerProductManagementDependencyProvider;
use Spryker\Zed\Store\Communication\Plugin\Form\StoreRelationToggleFormTypePlugin;

class ProductManagementDependencyProvider extends SprykerProductManagementDependencyProvider
{
    /**
     * @return \Spryker\Zed\ProductManagement\Communication\Plugin\ProductAbstractViewPluginInterface[]
     */
    protected function getProductAbstractViewPlugins()
    {
        return [
            new CmsBlockProductAbstractBlockListViewPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\Kernel\Communication\Form\FormTypeInterface
     */
    protected function getStoreRelationFormTypePlugin()
    {
        return new StoreRelationToggleFormTypePlugin();
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Money\Communication\Plugin\Form\MoneyFormTypePlugin
     */
    protected function createMoneyFormTypePlugin(Container $container)
    {
        return new MoneyFormTypePlugin();
    }

    /**
     * @return \Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductConcreteEditFormExpanderPluginInterface[]
     */
    protected function getProductConcreteEditFormExpanderPlugins(): array
    {
        return [
            new DiscontinuedProductConcreteEditFormExpanderPlugin(), #ProductDiscontinuedFeature
            new ProductConcreteEditFormExpanderPlugin(), #ProductAlternativeFeature
        ];
    }

    /**
     * @return \Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductConcreteFormEditTabsExpanderPluginInterface[]
     */
    protected function getProductConcreteFormEditTabsExpanderPlugins(): array
    {
        return [
            new DiscontinueProductConcreteFormEditTabsExpanderPlugin(),
            new ProductConcreteFormEditTabsExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductConcreteFormEditDataProviderExpanderPluginInterface[]
     */
    protected function getProductConcreteFormEditDataProviderExpanderPlugins(): array
    {
        return [
            new DiscontinueProductConcreteFormEditDataProviderExpanderPlugin(), #ProductDiscontinuedFeature
            new ProductConcreteFormEditDataProviderExpanderPlugin(), #ProductAlternativeFeature
        ];
    }

    /**
     * @return \Spryker\Zed\ProductManagementExtension\Dependency\Plugin\ProductFormTransferMapperExpanderPluginInterface[]
     */
    protected function getProductFormTransferMapperExpanderPlugins(): array
    {
        return [
            new ProductFormTransferMapperExpanderPlugin(), #ProductAlternativeFeature
            new DiscontinuedNotesProductFormTransferMapperExpanderPlugin(), #ProductDiscontinuedFeature
        ];
    }
}
