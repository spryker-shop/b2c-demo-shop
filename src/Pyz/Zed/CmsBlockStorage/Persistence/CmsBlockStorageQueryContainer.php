<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsBlockStorage\Persistence;

use Orm\Zed\CmsBlock\Persistence\Base\SpyCmsBlockGlossaryKeyMappingQuery;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery;
use Orm\Zed\FirstSpiritCmsBlockStorage\Persistence\FsCmsBlockDataConnectorQuery;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\CmsBlockStorage\Persistence\CmsBlockStorageQueryContainer as SprykerCmsBlockStorageQueryContainer;

class CmsBlockStorageQueryContainer extends SprykerCmsBlockStorageQueryContainer
{
    /**
     * @param array $cmsBlockIds
     *
     * @return \Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery
     */
    public function queryBlockWithRelationsByIds(array $cmsBlockIds): SpyCmsBlockQuery
    {
        $query = $this->getFactory()->createCmsBlockQuery()
            ->filterByIdCmsBlock_In($cmsBlockIds)
            ->joinWithCmsBlockTemplate()
            ->joinWithSpyCmsBlockStore()
            ->useSpyCmsBlockStoreQuery()
            ->joinWithSpyStore()
            ->endUse();

        $cmsBlockGlossaryKeyMappings = SpyCmsBlockGlossaryKeyMappingQuery::create()
            ->filterByFkCmsBlock_In($cmsBlockIds)
            ->find();
        if (!$cmsBlockGlossaryKeyMappings->isEmpty()) {
            $query = $query->joinWithSpyCmsBlockGlossaryKeyMapping()
                ->useSpyCmsBlockGlossaryKeyMappingQuery()
                ->joinWithGlossaryKey()
                ->endUse();
        }

//        $fsCmsBlocks = FsCmsBlockDataConnectorQuery::create()
//            ->filterByFkCmsBlock_In($cmsBlockIds)
//            ->find();
//
//        if (!$fsCmsBlocks->isEmpty()) {
//            $query = $query->joinWithFsCmsBlockDataConnector();
//        }

        return $query->setFormatter(ModelCriteria::FORMAT_ARRAY);
    }
}
