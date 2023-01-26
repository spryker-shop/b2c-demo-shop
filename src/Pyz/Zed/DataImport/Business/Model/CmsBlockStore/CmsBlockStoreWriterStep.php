<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\CmsBlockStore;

use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockStoreQuery;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Spryker\Zed\CmsBlock\Dependency\CmsBlockEvents;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CmsBlockStoreWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    /**
     * @var int
     */
    public const BULK_SIZE = 100;

    /**
     * @var string
     */
    public const KEY_BLOCK_KEY = 'block_key';

    /**
     * @var string
     */
    public const KEY_STORE_NAME = 'store_name';

    /**
     * @var array<int> Keys are CMS Block names, values are CMS Block IDs.
     */
    protected static $idCmsBlockBuffer = [];

    /**
     * @var array<int> Keys are store names, values are store ids.
     */
    protected static $idStoreBuffer = [];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $idCmsBlock = $this->getIdCmsBlockByKey($dataSet[static::KEY_BLOCK_KEY]);

        (new SpyCmsBlockStoreQuery())
            ->filterByFkCmsBlock($idCmsBlock)
            ->filterByFkStore($this->getIdStoreByName($dataSet[static::KEY_STORE_NAME]))
            ->findOneOrCreate()
            ->save();

        $this->addPublishEvents(CmsBlockEvents::CMS_BLOCK_PUBLISH, $idCmsBlock);
    }

    /**
     * @param string $cmsBlockKey
     *
     * @throws \Spryker\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return int
     */
    protected function getIdCmsBlockByKey(string $cmsBlockKey): int
    {
        if (isset(static::$idCmsBlockBuffer[$cmsBlockKey])) {
            return static::$idCmsBlockBuffer[$cmsBlockKey];
        }

        $cmsBlockEntity = SpyCmsBlockQuery::create()->findOneByKey($cmsBlockKey);

        if (!$cmsBlockEntity) {
            throw new EntityNotFoundException(sprintf('CmsBlock not found by block key "%s"', $cmsBlockKey));
        }

        static::$idCmsBlockBuffer[$cmsBlockKey] = $cmsBlockEntity->getIdCmsBlock();

        return static::$idCmsBlockBuffer[$cmsBlockKey];
    }

    /**
     * @param string $storeName
     *
     * @throws \Spryker\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return int
     */
    protected function getIdStoreByName(string $storeName): int
    {
        if (isset(static::$idStoreBuffer[$storeName])) {
            return static::$idStoreBuffer[$storeName];
        }

        $storeEntity = SpyStoreQuery::create()->findOneByName($storeName);

        if (!$storeEntity) {
            throw new EntityNotFoundException(sprintf('Store not found by store name "%s"', $storeName));
        }

        static::$idStoreBuffer[$storeName] = $storeEntity->getIdStore();

        return static::$idStoreBuffer[$storeName];
    }
}
