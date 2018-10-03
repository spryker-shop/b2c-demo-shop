<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ProductSetWidget\Plugin\CmsContentWidgetProductSetConnector;

use Generated\Shared\Transfer\ProductSetDataStorageTransfer;
use SprykerShop\Yves\ProductLabelWidget\Plugin\ProductWidget\ProductAbstractLabelWidgetPlugin;
use SprykerShop\Yves\ProductSetWidget\Plugin\CmsContentWidgetProductSetConnector\ProductSetWidgetPlugin as SprykerProductSetWidgetPlugin;

class ProductSetWidgetPlugin extends SprykerProductSetWidgetPlugin
{
    /**
     * @param \Generated\Shared\Transfer\ProductSetDataStorageTransfer $productSetDataStorageTransfer
     * @param \Generated\Shared\Transfer\ProductViewTransfer[] $productViewTransfers
     *
     * @return void
     */
    public function initialize(ProductSetDataStorageTransfer $productSetDataStorageTransfer, array $productViewTransfers): void
    {
        $this->addWidgets([
            ProductAbstractLabelWidgetPlugin::class,
        ]);

       parent::initialize($productSetDataStorageTransfer, $productViewTransfers);
    }

}
