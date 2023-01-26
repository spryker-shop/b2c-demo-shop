<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\PropelOrm\Stub;

use Exception;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Orm\Zed\Product\Persistence\SpyProductAbstractLocalizedAttributes;
use Spryker\Zed\Product\Persistence\ProductQueryContainerInterface;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

class ProductManagerStub
{
    use DatabaseTransactionHandlerTrait;

    /**
     * @var \Spryker\Zed\Product\Persistence\ProductQueryContainerInterface
     */
    protected $productQueryContainer;

    /**
     * @param \Spryker\Zed\Product\Persistence\ProductQueryContainerInterface $productQueryContainer
     */
    public function __construct(ProductQueryContainerInterface $productQueryContainer)
    {
        $this->productQueryContainer = $productQueryContainer;
    }

    /**
     * @param string $sku
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstract
     */
    protected function createProductAbstractEntity($sku): SpyProductAbstract
    {
        $productAbstractEntity = new SpyProductAbstract();
        $productAbstractEntity->setSku($sku);
        $productAbstractEntity->setAttributes('{}');
        $productAbstractEntity->save();

        return $productAbstractEntity;
    }

    /**
     * @param string $name
     * @param int $idProductAbstract
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractLocalizedAttributes
     */
    protected function createLocalizedAttributeEntity($name, $idProductAbstract): SpyProductAbstractLocalizedAttributes
    {
        $localizedAttributeEntity = new SpyProductAbstractLocalizedAttributes();
        $localizedAttributeEntity->setAttributes('{}');
        $localizedAttributeEntity->setFkLocale(66);
        $localizedAttributeEntity->setName($name);
        $localizedAttributeEntity->setFkProductAbstract($idProductAbstract);
        $localizedAttributeEntity->save();

        return $localizedAttributeEntity;
    }

    /**
     * @param string $sku
     * @param string $name
     *
     * @return int
     */
    public function addProductWithoutTransactionHandling($sku, $name): int
    {
        $this->productQueryContainer->getConnection()->beginTransaction();

        $productAbstractEntity = $this->createProductAbstractEntity($sku);
        $this->createLocalizedAttributeEntity($name, $productAbstractEntity->getIdProductAbstract());

        $this->productQueryContainer->getConnection()->commit();

        return $productAbstractEntity->getIdProductAbstract();
    }

    /**
     * @param string $sku
     * @param string $name
     *
     * @return void
     */
    public function addProductWithoutTransactionHandlingShouldThrowException($sku, $name): void
    {
        $this->productQueryContainer->getConnection()->beginTransaction();

        $productAbstractEntity = new SpyProductAbstract();
        $productAbstractEntity->setSku($sku);
        $productAbstractEntity->setAttributes('{}');
        $productAbstractEntity->save();

        $this->throwSampleException();

        $localizedAttributeEntity = new SpyProductAbstractLocalizedAttributes();
        $localizedAttributeEntity->setAttributes('{}');
        $localizedAttributeEntity->setFkLocale(66);
        $localizedAttributeEntity->setName($name);
        $localizedAttributeEntity->setFkProductAbstract($productAbstractEntity->getIdProductAbstract());
        $localizedAttributeEntity->save();

        $this->productQueryContainer->getConnection()->commit();
    }

    /**
     * @param string $sku
     * @param string $name
     *
     * @return void
     */
    public function addProductWithTransactionHandlingShouldRollbackAndThrowException($sku, $name): void
    {
        $this->handleDatabaseTransaction(function () use ($sku, $name): void {
            $productAbstractEntity = new SpyProductAbstract();
            $productAbstractEntity->setSku($sku);
            $productAbstractEntity->setAttributes('{}');
            $productAbstractEntity->save();

            $localizedAttributeEntity = new SpyProductAbstractLocalizedAttributes();
            $localizedAttributeEntity->setAttributes('{}');
            $localizedAttributeEntity->setFkLocale(66);
            $localizedAttributeEntity->setName($name);
            $localizedAttributeEntity->setFkProductAbstract($productAbstractEntity->getIdProductAbstract());
            $localizedAttributeEntity->save();

            $this->throwSampleException();
        }, $this->productQueryContainer->getConnection());
    }

    /**
     * @param string $sku
     * @param string $name
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductAbstractLocalizedAttributes
     */
    public function addProductWithTransactionHandlingShouldCommitAndReturnValue($sku, $name): SpyProductAbstractLocalizedAttributes
    {
        return $this->handleDatabaseTransaction(function () use ($sku, $name) {
            $productAbstractEntity = new SpyProductAbstract();
            $productAbstractEntity->setSku($sku);
            $productAbstractEntity->setAttributes('{}');
            $productAbstractEntity->save();

            $localizedAttributeEntity = new SpyProductAbstractLocalizedAttributes();
            $localizedAttributeEntity->setAttributes('{}');
            $localizedAttributeEntity->setFkLocale(66);
            $localizedAttributeEntity->setName($name);
            $localizedAttributeEntity->setFkProductAbstract($productAbstractEntity->getIdProductAbstract());
            $localizedAttributeEntity->save();

            return $localizedAttributeEntity;
        }, $this->productQueryContainer->getConnection());
    }

    /**
     * @throws \Exception
     *
     * @return void
     */
    protected function throwSampleException(): void
    {
        throw new Exception('DB error occured');
    }
}
