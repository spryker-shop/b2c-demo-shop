<?php

/**
 * This file is part of the Spryker Commerce OS.
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
            CmsBlockCategoryConnectorConfig::CATEGORY_TEMPLATE_WITH_CMS_BLOCK => '@CatalogPage/views/catalog-with-cms-block/catalog-with-cms-slot.twig',
        ];
        $templateList += parent::getTemplateList();

        return $templateList;
    }
}
