<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Category;

use Spryker\Zed\Category\CategoryConfig as CategoryCategoryConfig;
use Spryker\Zed\CmsBlockCategoryConnector\CmsBlockCategoryConnectorConfig;

class CategoryConfig extends CategoryCategoryConfig
{
    /**
     * @return array
     */
    public function getTemplateList()
    {
        $templateList = [
            CmsBlockCategoryConnectorConfig::CATEGORY_TEMPLATE_ONLY_CMS_BLOCK => '@CatalogPage/views/simple-cms-block/simple-cms-block.twig',
            CmsBlockCategoryConnectorConfig::CATEGORY_TEMPLATE_WITH_CMS_BLOCK => '@CatalogPage/views/catalog-with-cms-block/catalog-with-cms-block.twig',
        ];
        $templateList += parent::getTemplateList();

        return $templateList;
    }
}
