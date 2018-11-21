<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\CmsBlock\Category\Repository;

interface CategoryRepositoryInterface
{
    /**
     * @param string $categoryKey
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\CategoryByKeyNotFoundException
     *
     * @return int
     */
    public function getIdCategoryByCategoryKey($categoryKey);
}
