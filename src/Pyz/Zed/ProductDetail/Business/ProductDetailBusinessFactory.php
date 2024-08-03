<?php

namespace Pyz\Zed\ProductDetailWidget\Business;

use Pyz\Zed\ProductDetailWidget\Business\Manager\ProductDetailManager;
use Pyz\Zed\ProductDetailWidget\Business\Manager\ProductDetailManagerInterface;
use Pyz\Zed\ProductDetailWidget\Business\Reader\ProductDetailReader;
use Pyz\Zed\ProductDetailWidget\Business\Reader\ProductDetailReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\ProductDetailWidget\ProductDetailWidgetConfig getConfig()
 * @method \Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailRepositoryInterface getRepository()
 * @method \Pyz\Zed\ProductDetailWidget\Persistence\ProductDetailEntityManagerInterface getEntityManager()
 */
class ProductDetailBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\ProductDetailWidget\Business\Manager\ProductDetailManagerInterface
     */
    public function createProductDetailManager(): ProductDetailManagerInterface
    {
        return new ProductDetailManager(
            $this->getRepository(),
            $this->getEntityManager()
        );
    }

    /**
     * @return \Pyz\Zed\ProductDetailWidget\Business\Reader\ProductDetailReaderInterface
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
