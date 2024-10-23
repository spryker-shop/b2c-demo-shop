<?php

namespace Pyz\Zed\ProductDetail\Business;

use Pyz\Zed\ProductDetail\Business\Manager\ProductDetailManager;
use Pyz\Zed\ProductDetail\Business\Manager\ProductDetailManagerInterface;
use Pyz\Zed\ProductDetail\Business\Reader\ProductDetailReader;
use Pyz\Zed\ProductDetail\Business\Reader\ProductDetailReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\ProductDetail\ProductDetailConfig getConfig()
 * @method \Pyz\Zed\ProductDetail\Persistence\ProductDetailRepositoryInterface getRepository()
 * @method \Pyz\Zed\ProductDetail\Persistence\ProductDetailEntityManagerInterface getEntityManager()
 */
class ProductDetailBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\ProductDetail\Business\Manager\ProductDetailManagerInterface
     */
    public function createProductDetailManager(): ProductDetailManagerInterface
    {
        return new ProductDetailManager(
            $this->getRepository(),
            $this->getEntityManager()
        );
    }

    /**
     * @return \Pyz\Zed\ProductDetail\Business\Reader\ProductDetailReaderInterface
     */
    public function createProductDetailReader(): ProductDetailReaderInterface
    {
        return new ProductDetailReader($this->getRepository());
    }


    /*public function createProductWriter(): ProductDetailPageWriterInterface
    {
        return new ProductDetailPageWriter($this->getEntityManager());
    }*/
}
