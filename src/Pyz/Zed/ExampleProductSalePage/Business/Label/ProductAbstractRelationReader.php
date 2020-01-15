<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ExampleProductSalePage\Business\Label;

use Generated\Shared\Transfer\ProductLabelProductAbstractRelationsTransfer;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabel;
use Pyz\Zed\ExampleProductSalePage\Business\Exception\ProductLabelSaleNotFoundException;
use Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig;
use Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface;

class ProductAbstractRelationReader implements ProductAbstractRelationReaderInterface
{
    /**
     * @var \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface
     */
    protected $productSaleQueryContainer;

    /**
     * @var \Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig
     */
    protected $productSaleConfig;

    /**
     * @param \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePageQueryContainerInterface $productSaleQueryContainer
     * @param \Pyz\Zed\ExampleProductSalePage\ExampleProductSalePageConfig $productSaleConfig
     */
    public function __construct(ExampleProductSalePageQueryContainerInterface $productSaleQueryContainer, ExampleProductSalePageConfig $productSaleConfig)
    {
        $this->productSaleQueryContainer = $productSaleQueryContainer;
        $this->productSaleConfig = $productSaleConfig;
    }

    /**
     * @return \Generated\Shared\Transfer\ProductLabelProductAbstractRelationsTransfer[]
     */
    public function findProductLabelProductAbstractRelationChanges()
    {
        $result = [];

        $productLabelNewEntity = $this->getProductLabelNewEntity();

        if (!$productLabelNewEntity->getIsActive()) {
            return [];
        }

        $relationsToDeAssign = $this->findRelationsBecomingInactive($productLabelNewEntity);
        $relationsToAssign = $this->findRelationsBecomingActive($productLabelNewEntity);

        $idProductLabels = array_keys($relationsToDeAssign) + array_keys($relationsToAssign);
        foreach ($idProductLabels as $idProductLabel) {
            $result[] = $this->mapRelationTransfer($idProductLabel, $relationsToAssign, $relationsToDeAssign);
        }

        return $result;
    }

    /**
     * @throws \Pyz\Zed\ExampleProductSalePage\Business\Exception\ProductLabelSaleNotFoundException
     *
     * @return \Orm\Zed\ProductLabel\Persistence\SpyProductLabel
     */
    protected function getProductLabelNewEntity()
    {
        $labelNewName = $this->productSaleConfig->getLabelSaleName();
        $productLabelNewEntity = $this->productSaleQueryContainer
            ->queryProductLabelByName($labelNewName)
            ->findOne();

        if (!$productLabelNewEntity) {
            throw new ProductLabelSaleNotFoundException(sprintf(
                'Product Label "%1$s" doesn\'t exists. You can fix this problem by persisting a new Product Label entity into your database with "%1$s" name.',
                $labelNewName
            ));
        }

        return $productLabelNewEntity;
    }

    /**
     * @param \Orm\Zed\ProductLabel\Persistence\SpyProductLabel $productLabelEntity
     *
     * @return array
     */
    protected function findRelationsBecomingInactive(SpyProductLabel $productLabelEntity)
    {
        $relations = [];

        $productLabelProductAbstractEntities = $this->productSaleQueryContainer
            ->queryRelationsBecomingInactive($productLabelEntity->getIdProductLabel())
            ->find();

        foreach ($productLabelProductAbstractEntities as $productLabelProductAbstractEntity) {
            $relations[$productLabelEntity->getIdProductLabel()][] = $productLabelProductAbstractEntity->getFkProductAbstract();
        }

        return $relations;
    }

    /**
     * @param \Orm\Zed\ProductLabel\Persistence\SpyProductLabel $productLabelEntity
     *
     * @return array
     */
    protected function findRelationsBecomingActive(SpyProductLabel $productLabelEntity)
    {
        $relations = [];

        $productAbstractEntities = $this->productSaleQueryContainer
            ->queryRelationsBecomingActive($productLabelEntity->getIdProductLabel())
            ->find();

        foreach ($productAbstractEntities as $productAbstractEntity) {
            $relations[$productLabelEntity->getIdProductLabel()][] = $productAbstractEntity->getIdProductAbstract();
        }

        return $relations;
    }

    /**
     * @param int $idProductLabel
     * @param array $relationsToAssign
     * @param array $relationsToDeAssign
     *
     * @return \Generated\Shared\Transfer\ProductLabelProductAbstractRelationsTransfer
     */
    protected function mapRelationTransfer($idProductLabel, array $relationsToAssign, array $relationsToDeAssign)
    {
        $productLabelProductAbstractRelationsTransfer = new ProductLabelProductAbstractRelationsTransfer();
        $productLabelProductAbstractRelationsTransfer->setIdProductLabel($idProductLabel);

        if (!empty($relationsToAssign[$idProductLabel])) {
            $productLabelProductAbstractRelationsTransfer->setIdsProductAbstractToAssign($relationsToAssign[$idProductLabel]);
        }

        if (!empty($relationsToDeAssign[$idProductLabel])) {
            $productLabelProductAbstractRelationsTransfer->setIdsProductAbstractToDeAssign($relationsToDeAssign[$idProductLabel]);
        }

        return $productLabelProductAbstractRelationsTransfer;
    }
}
