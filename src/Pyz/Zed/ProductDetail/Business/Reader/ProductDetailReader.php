<?php


namespace Pyz\Zed\ProductDetailWidget\Business\Reader;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Pyz\Zed\ProductDetailWidget\Business\Reader\ProductDetailReaderInterface;

class ProductDetailReader implements ProductDetailReaderInterface
{
    /**
     * @var \Pyz\Zed\ProductDetailWidget\Business\Reader\ProductDetailReaderInterface
     */
    protected $productAbstractReader;

    /**
     * @param \Pyz\Zed\ProductDetailWidget\Business\Reader\ProductDetailReaderInterface $productAbstractReader
     */
    public function __construct(ProductDetailReaderInterface $productAbstractReader)
    {
        $this->productAbstractReader = $productAbstractReader;
    }

    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function findProductAbstractById(ProductAbstractTransfer $productAbstractTransfer): ProductAbstractTransfer
    {
        $productId = $productAbstractTransfer->getIdProductAbstract();
        if ($productId === null) {
            throw new \InvalidArgumentException('Product ID cannot be null.');
        }

        $productAbstractTransfer = $this->productAbstractReader->findProductAbstractById($productId);

        if ($productAbstractTransfer === null) {
            throw new \RuntimeException(sprintf('Product abstract with ID %d not found.', $productId));
        }

        return $productAbstractTransfer;
    }
}
