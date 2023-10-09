<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Communication\Plugin;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\ProductLabel\Dependency\Plugin\ProductLabelRelationUpdaterPluginInterface;

/**
 * @method \Pyz\Zed\ExampleProductSalePage\Business\ExampleProductSalePageFacadeInterface getFacade()
 * @method \Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig getConfig()
 * @method \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface getQueryContainer()
 */
class ExampleProductSalePageLabelUpdaterPlugin extends AbstractPlugin implements ProductLabelRelationUpdaterPluginInterface
{
    /**
     * @return array<\Generated\Shared\Transfer\ProductLabelProductAbstractRelationsTransfer>
     */
    public function findProductLabelProductAbstractRelationChanges(): array
    {
        return $this->getFacade()->findProductLabelProductAbstractRelationChanges();
    }
}
