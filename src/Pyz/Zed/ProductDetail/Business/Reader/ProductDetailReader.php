<?php


namespace Pyz\Zed\ProductDetail\Business\Reader;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductResponseTransfer;
use Pyz\Zed\ProductDetail\Business\Reader\ProductDetailReaderInterface;
use Pyz\Zed\ProductDetail\Persistence\ProductDetailRepositoryInterface;

class ProductDetailReader implements ProductDetailReaderInterface
{
    /**
     * @var \Pyz\Zed\ProductDetail\Business\Reader\ProductDetailReaderInterface
     */
    protected $productDetailReader;

    /**
     * @param \Pyz\Zed\ProductDetail\Business\Reader\ProductDetailReaderInterface $productDetailReader
     */
    public function __construct(ProductDetailRepositoryInterface $productDetailReader)
    {
        $this->productDetailReader = $productDetailReader;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function findProductAbstractBySku(ProductAbstractTransfer $productAbstractTransfer): ProductResponseTransfer
    {
        $productId = $productAbstractTransfer->getSku();
        if ($productId === null) {
            throw new \InvalidArgumentException('Product ID cannot be null.');
        }

        $productAbstractTransfer = $this->productDetailReader->findProductAbstractBySku($productId);

        if ($productAbstractTransfer === null) {
            throw new \RuntimeException(sprintf('Product abstract with ID %d not found.', $productId));
        }

        return $productAbstractTransfer;
    }
}
