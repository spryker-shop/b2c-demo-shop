<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PersistentCart;

use Spryker\Zed\PersistentCart\PersistentCartDependencyProvider as SprykerPersistentCartDependencyProvider;
use Spryker\Zed\PersistentCartExtension\Dependency\Plugin\QuoteItemFinderPluginInterface;
use Spryker\Zed\ProductBundle\Communication\Plugin\PersistentCart\BundleProductQuoteItemFinderPlugin;
use Spryker\Zed\ProductBundle\Communication\Plugin\PersistentCart\RemoveBundleChangeRequestExpanderPlugin;

class PersistentCartDependencyProvider extends SprykerPersistentCartDependencyProvider
{
    /**
     * @return \Spryker\Zed\PersistentCartExtension\Dependency\Plugin\QuoteItemFinderPluginInterface
     */
    protected function getQuoteItemFinderPlugin(): QuoteItemFinderPluginInterface
    {
        return new BundleProductQuoteItemFinderPlugin(); #ProductBundleFeature
    }

    /**
     * @return \Spryker\Zed\PersistentCartExtension\Dependency\Plugin\CartChangeRequestExpandPluginInterface[]
     */
    protected function getRemoveItemsRequestExpanderPlugins(): array
    {
        return [
            new RemoveBundleChangeRequestExpanderPlugin(), #ProductBundleFeature
        ];
    }
}
