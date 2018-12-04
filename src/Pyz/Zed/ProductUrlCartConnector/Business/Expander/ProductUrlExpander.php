<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductUrlCartConnector\Business\Expander;

use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;
use Spryker\Zed\Product\Business\ProductFacadeInterface;

class ProductUrlExpander implements ProductUrlExpanderInterface
{
    /**
     * @var \Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @var \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    protected $localeFacade;

    /**
     * @param \Spryker\Zed\Product\Business\ProductFacadeInterface $productFacade
     * @param \Spryker\Zed\Locale\Business\LocaleFacadeInterface $localeFacade
     */
    public function __construct(
        ProductFacadeInterface $productFacade,
        LocaleFacadeInterface $localeFacade
    ) {
        $this->productFacade = $productFacade;
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartChangeTransfer
     */
    public function expandItems(CartChangeTransfer $cartChangeTransfer)
    {
        foreach ($cartChangeTransfer->getItems() as $itemTransfer) {
            $this->expandItemsWithUrl($itemTransfer);
        }

        return $cartChangeTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return void
     */
    protected function expandItemsWithUrl(ItemTransfer $itemTransfer)
    {
        $idLocale = $this->localeFacade->getCurrentLocale()->getIdLocale();
        $productAbstractTransfer = new ProductAbstractTransfer();
        $productAbstractTransfer
            ->setSku($itemTransfer->getAbstractSku())
            ->setIdProductAbstract($itemTransfer->getIdProductAbstract());

        $productUrlTransfer = $this->productFacade->getProductUrl($productAbstractTransfer);
        foreach ($productUrlTransfer->getUrls() as $localizedUrlTransfer) {
            if ($localizedUrlTransfer->getLocale()->getIdLocale() == $idLocale) {
                $itemTransfer->setUrl($localizedUrlTransfer->getUrl());
            }
        }
    }
}
