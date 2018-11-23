<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CatalogPage\Controller;

use SprykerShop\Yves\CatalogPage\Controller\CatalogController as SprykerCatalogController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerShop\Yves\CatalogPage\CatalogPageFactory getFactory()
 * @method \Spryker\Client\Catalog\CatalogClientInterface getClient()
 */
class CatalogController extends SprykerCatalogController
{
    const CATEGORY_BANNER_PATH = '/assets/images/';

    const KEY_PARENTS = 'parents';

    /**
     * @var array
     */
    protected $availableBannerTypes = ['.jpg', '.png'];

    /**
     * @param array $categoryNode
     * @param int $idCategoryNode
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executeIndexAction(array $categoryNode, int $idCategoryNode, Request $request): array
    {
        $viewData = parent::executeIndexAction($categoryNode, $idCategoryNode, $request);
        $viewData['category']['banner_path'] = $this->getCategoryBannerPath($categoryNode);

        return $viewData;
    }

    /**
     * @param array $categoryNode
     *
     * @return string|null
     */
    protected function getCategoryBannerPath(array $categoryNode)
    {
        $fileName = $this->formatBannerName($categoryNode);

        foreach ($this->availableBannerTypes as $type) {
            $filePath = APPLICATION_ROOT_DIR . '/public/Yves' . $fileName . $type;
            if (file_exists($filePath)) {
                return $fileName . $type;
            }
        }

        if (array_key_exists(self::KEY_PARENTS, $categoryNode)) {
            return $this->getCategoryBannerPath($categoryNode[self::KEY_PARENTS][0]);
        }

        return null;
    }

    /**
     * @param array $categoryNode
     *
     * @return string
     */
    protected function formatBannerName(array $categoryNode)
    {
        return self::CATEGORY_BANNER_PATH . 'category-' . $categoryNode['id_category'];
    }
}
