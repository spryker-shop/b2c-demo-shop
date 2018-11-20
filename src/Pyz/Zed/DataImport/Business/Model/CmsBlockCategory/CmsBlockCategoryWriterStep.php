<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\CmsBlockCategory;

use Orm\Zed\Category\Persistence\SpyCategoryQuery;
use Orm\Zed\Category\Persistence\SpyCategoryTemplateQuery;
use Orm\Zed\CmsBlock\Persistence\SpyCmsBlockQuery;
use Orm\Zed\CmsBlockCategoryConnector\Persistence\SpyCmsBlockCategoryConnectorQuery;
use Orm\Zed\CmsBlockCategoryConnector\Persistence\SpyCmsBlockCategoryPositionQuery;
use Spryker\Zed\CmsBlockCategoryConnector\Dependency\CmsBlockCategoryConnectorEvents;
use Spryker\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CmsBlockCategoryWriterStep extends PublishAwareStep implements DataImportStepInterface
{
    public const KEY_BLOCK_NAME = 'block_name';
    public const KEY_CATEGORY_KEY = 'category_key';
    public const KEY_CATEGORY_TEMPLATE_NAME = 'template_name';
    public const KEY_CMS_BLOCK_CATEGORY_POSITION_NAME = 'cms_block_category_position_name';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Spryker\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet)
    {
        $cmsBlockEntity = SpyCmsBlockQuery::create()->findOneByName($dataSet[static::KEY_BLOCK_NAME]);
        if (!$cmsBlockEntity) {
              throw new EntityNotFoundException(sprintf('CmsBlock not found by block name "%s"', $dataSet[static::KEY_BLOCK_NAME]));
        }

        $categoryEntity = SpyCategoryQuery::create()->findOneByCategoryKey($dataSet[static::KEY_CATEGORY_KEY]);
        if (!$categoryEntity) {
            throw new EntityNotFoundException(sprintf('Category not found by category key "%s"', $dataSet[static::KEY_CATEGORY_KEY]));
        }

        $categoryTemplateEntity = SpyCategoryTemplateQuery::create()->findOneByName($dataSet[static::KEY_CATEGORY_TEMPLATE_NAME]);
        if (!$categoryTemplateEntity) {
            throw new EntityNotFoundException(sprintf('CategoryTemplate not found by name "%s"', $dataSet[static::KEY_CATEGORY_TEMPLATE_NAME]));
        }

        $cmsBlockCategoryPositionEntity = SpyCmsBlockCategoryPositionQuery::create()->findOneByName($dataSet[static::KEY_CMS_BLOCK_CATEGORY_POSITION_NAME]);
        if (!$cmsBlockCategoryPositionEntity) {
            throw new EntityNotFoundException(sprintf('CmsBlockCategoryPosition not found by name "%s"', $dataSet[static::KEY_CMS_BLOCK_CATEGORY_POSITION_NAME]));
        }

        $cmsBlockCategoryConnectorEntity = SpyCmsBlockCategoryConnectorQuery::create()
            ->filterByFkCmsBlock($cmsBlockEntity->getIdCmsBlock())
            ->filterByFkCategory($categoryEntity->getIdCategory())
            ->filterByFkCategoryTemplate($categoryTemplateEntity->getIdCategoryTemplate())
            ->filterByFkCmsBlockCategoryPosition($cmsBlockCategoryPositionEntity->getIdCmsBlockCategoryPosition())
            ->findOneOrCreate();

        if ($cmsBlockCategoryConnectorEntity->isNew() || $cmsBlockCategoryConnectorEntity->isModified()) {
            $cmsBlockCategoryConnectorEntity->save();

            $this->addPublishEvents(CmsBlockCategoryConnectorEvents::CMS_BLOCK_CATEGORY_CONNECTOR_PUBLISH, $cmsBlockCategoryConnectorEntity->getFkCategory());
        }
    }
}
