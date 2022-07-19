<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\CmsBlockCategoryPosition;

use Orm\Zed\CmsBlockCategoryConnector\Persistence\SpyCmsBlockCategoryPositionQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CmsBlockCategoryPositionWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    public const BULK_SIZE = 100;
    public const KEY_NAME = 'name';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet)
    {
        SpyCmsBlockCategoryPositionQuery::create()
            ->filterByName($dataSet[static::KEY_NAME])
            ->findOneOrCreate()
            ->save();
    }
}
