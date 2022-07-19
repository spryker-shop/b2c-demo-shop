<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CmsPage\Controller;

use ESpirit\Shared\FirstSpiritPreview\FirstSpiritPreviewConstants;
use SprykerShop\Yves\CmsPage\Controller\PreviewController as SprykerPreviewController;

class PreviewController extends SprykerPreviewController
{
    /**
     * @param int $idCmsPage
     * @param array $metaData
     *
     * @return array
     */
    protected function executeIndexAction(int $idCmsPage, array $metaData): array
    {
        $viewData = parent::executeIndexAction($idCmsPage, $metaData);
        $viewData[FirstSpiritPreviewConstants::VIEW_DATA_PAGE_TYPE_KEY] = FirstSpiritPreviewConstants::CMS_PAGE_TYPE;
        $viewData[FirstSpiritPreviewConstants::VIEW_DATA_PAGE_ID_KEY] = $idCmsPage;

        return $viewData;
    }
}
