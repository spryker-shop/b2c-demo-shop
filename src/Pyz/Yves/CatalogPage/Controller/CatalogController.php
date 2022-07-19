<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CatalogPage\Controller;

use ESpirit\Shared\FirstSpiritPreview\FirstSpiritPreviewConstants;
use SprykerShop\Yves\CatalogPage\Controller\CatalogController as SprykerCatalogController;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends SprykerCatalogController
{
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
        $viewData[FirstSpiritPreviewConstants::VIEW_DATA_PAGE_TYPE_KEY] = FirstSpiritPreviewConstants::CATEGORY_PAGE_TYPE;
        $viewData[FirstSpiritPreviewConstants::VIEW_DATA_PAGE_ID_KEY] = sprintf('%s_%d', FirstSpiritPreviewConstants::CATEGORY_PAGE_TYPE, $categoryNode['id_category']);

        return $viewData;
    }
}
