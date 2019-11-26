<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Category;

use Pyz\Zed\CmsSlotBlockCategoryConnector\CmsSlotBlockCategoryConnector;
use Spryker\Zed\Category\CategoryConfig as CategoryCategoryConfig;

class CategoryConfig extends CategoryCategoryConfig
{
    /**
     * @return array
     */
    public function getTemplateList()
    {
        $templateList = [
            CmsSlotBlockCategoryConnector::CATEGORY_TEMPLATE_WITH_CMS_SLOT => '@CatalogPage/views/catalog-with-cms-block/catalog-with-cms-slot.twig',
        ];
        $templateList += parent::getTemplateList();

        return $templateList;
    }
}
