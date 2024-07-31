<?php

namespace Pyz\Zed\ProductDetailPageWidget\Business;

use Pyz\Zed\ProductDetailPageWidget\Business\Manager\ProductDetailManager;
use Pyz\Zed\ProductDetailPageWidget\Business\Manager\ProductDetailManagerInterface;
use Pyz\Zed\ProductDetailPageWidget\Business\Reader\ProductDetailWriter;
use Pyz\Zed\ProductDetailPageWidget\Business\Writer\ProductDetailPageWriterInterface;
use Pyz\Zed\ProductDetailPageWidget\Business\Writer\ProductDetailPageWriter;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\ProductDetailPageWidget\ProductDetailWidgetConfig getConfig()
 * @method \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailRepositoryInterface getRepository()
 * @method \Pyz\Zed\ProductDetailPageWidget\Persistence\ProductDetailEntityManagerInterface getEntityManager()
 */
class ProductDetailWidgetBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\ProductDetailPageWidget\Business\Manager\ProductDetailManagerInterface
     */
    public function createProductDetailManager(): ProductDetailManagerInterface
    {
        return new ProductDetailManager(
            $this->getRepository(),
            $this->getEntityManager()
        );
    }

    /**
     * @return \Pyz\Zed\ProductDetailPageWidget\Business\Reader\ProductDetailWriterInterface
     */
    public function createProductDetailReader(): ProductDetailPageWriterInterface
    {
        return new ProductDetailWriter($this->getRepository());
    }


    public function createProductWriter(): ProductDetailPageWriterInterface
    {
        return new ProductDetailPageWriter($this->getEntityManager());
    }
}
