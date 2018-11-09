<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CartNote;

use Spryker\Zed\CartNote\CartNoteDependencyProvider as SprykerCartNoteDependencyProvider;
use Spryker\Zed\CartNoteExtension\Dependency\Plugin\QuoteItemFinderPluginInterface;
use Spryker\Zed\CartNoteProductBundleConnector\Communication\Plugin\BundleProductQuoteItemFinderPlugin;

class CartNoteDependencyProvider extends SprykerCartNoteDependencyProvider
{
    /**
     * @return \Spryker\Zed\CartNoteExtension\Dependency\Plugin\QuoteItemFinderPluginInterface
     */
    protected function getQuoteItemsFinderPlugin(): QuoteItemFinderPluginInterface
    {
        return new BundleProductQuoteItemFinderPlugin();
    }
}
