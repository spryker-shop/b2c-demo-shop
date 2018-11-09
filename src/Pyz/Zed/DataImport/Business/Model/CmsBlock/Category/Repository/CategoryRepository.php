<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\CmsBlock\Category\Repository;

use ArrayObject;
use Orm\Zed\Category\Persistence\SpyCategoryQuery;
use Pyz\Zed\DataImport\Business\Exception\CategoryByKeyNotFoundException;

class CategoryRepository implements CategoryRepositoryInterface
{
    public const ID_CATEGORY_NODE = 'id_category_node';
    public const ID_LOCALE = 'idLocale';
    public const URL = 'url';
    public const ID_CATEGORY = 'id_category';

    /**
     * @var \ArrayObject
     */
    protected $categoryKeys;

    /**
     * @var \ArrayObject
     */
    protected $categoryUrls;

    public function __construct()
    {
        $this->categoryKeys = new ArrayObject();
        $this->categoryUrls = new ArrayObject();
    }

    /**
     * @param string $categoryKey
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\CategoryByKeyNotFoundException
     *
     * @return int
     */
    public function getIdCategoryByCategoryKey($categoryKey)
    {
        if ($this->categoryKeys->count() === 0) {
            $this->loadCategoryKeys();
        }

        if (!$this->categoryKeys->offsetExists($categoryKey)) {
            throw new CategoryByKeyNotFoundException(sprintf(
                'Category by key "%s" not found. Maybe you have a typo in the category key.',
                $categoryKey
            ));
        }

        return $this->categoryKeys[$categoryKey][static::ID_CATEGORY];
    }

    /**
     * @return void
     */
    private function loadCategoryKeys()
    {
        $categoryEntityCollection = SpyCategoryQuery::create()
            ->joinWithNode()
            ->find();

        foreach ($categoryEntityCollection as $categoryEntity) {
            $this->categoryKeys[$categoryEntity->getCategoryKey()] = [
                static::ID_CATEGORY => $categoryEntity->getIdCategory(),
                static::ID_CATEGORY_NODE => $categoryEntity->getNodes()->getFirst()->getIdCategoryNode(),
            ];
        }
    }
}
