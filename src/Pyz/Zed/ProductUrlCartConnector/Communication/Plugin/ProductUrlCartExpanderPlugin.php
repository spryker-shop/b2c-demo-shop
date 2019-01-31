<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductUrlCartConnector\Communication\Plugin;

use Generated\Shared\Transfer\CartChangeTransfer;
use Spryker\Zed\Cart\Dependency\ItemExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\ProductUrlCartConnector\Business\ProductUrlCartConnectorFacade getFacade()
 * @method \Pyz\Zed\ProductUrlCartConnector\Communication\ProductUrlCartConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductUrlCartConnector\ProductUrlCartConnectorConfig getConfig()
 */
class ProductUrlCartExpanderPlugin extends AbstractPlugin implements ItemExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer)
    {
        $this->getFacade()->expandItems($cartChangeTransfer);

        return $cartChangeTransfer;
    }
}
