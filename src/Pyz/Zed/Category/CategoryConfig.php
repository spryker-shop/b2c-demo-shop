<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Category;

use Spryker\Zed\Category\CategoryConfig as SprykerCategoryConfig;

class CategoryConfig extends SprykerCategoryConfig
{
    /**
     * @return array<string>
     */
    public function getTemplateList(): array
    {
        $templateList = [
            'Catalog + CMS Slot' => '@CatalogPage/views/catalog-with-cms-block/catalog-with-cms-slot.twig',
        ];
        $templateList += parent::getTemplateList();

        return $templateList;
    }
}
