<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\CmsBlockStore;

use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockStoreQuery;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Spryker\Zed\CmsBlock\Dependency\CmsBlockEvents;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CmsBlockStoreWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    public const BULK_SIZE = 100;
    public const KEY_BLOCK_NAME = 'block_name';
    public const KEY_STORE_NAME = 'store_name';

    /**
     * @var int[] Keys are CMS Block names, values are CMS Block IDs.
     */
    protected static $idCmsBlockBuffer = [];

    /**
     * @var int[] Keys are store names, values are store ids.
     */
    protected static $idStoreBuffer = [];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet)
    {
        $idCmsBlock = $this->getIdCmsBlockByName($dataSet[static::KEY_BLOCK_NAME]);

        (new SpyCmsBlockStoreQuery())
            ->filterByFkCmsBlock($idCmsBlock)
            ->filterByFkStore($this->getIdStoreByName($dataSet[static::KEY_STORE_NAME]))
            ->findOneOrCreate()
            ->save();

        $this->addPublishEvents(CmsBlockEvents::CMS_BLOCK_PUBLISH, $idCmsBlock);
    }

    /**
     * @param string $cmsBlockName
     *
     * @return int
     */
    protected function getIdCmsBlockByName($cmsBlockName)
    {
        if (!isset(static::$idCmsBlockBuffer[$cmsBlockName])) {
            static::$idCmsBlockBuffer[$cmsBlockName] =
                SpyCmsBlockQuery::create()->findOneByName($cmsBlockName)->getIdCmsBlock();
        }
        return static::$idCmsBlockBuffer[$cmsBlockName];
    }

    /**
     * @param string $storeName
     *
     * @return int
     */
    protected function getIdStoreByName($storeName)
    {
        if (!isset(static::$idStoreBuffer[$storeName])) {
            static::$idStoreBuffer[$storeName] =
                SpyStoreQuery::create()->findOneByName($storeName)->getIdStore();
        }
        return static::$idStoreBuffer[$storeName];
    }
}
