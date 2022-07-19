<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CmsPage\Controller;

use ESpirit\Shared\FirstSpiritPreview\FirstSpiritPreviewConstants;
use Generated\Shared\Transfer\LocaleCmsPageDataTransfer;
use SprykerShop\Yves\CmsPage\Controller\CmsController as SprykerCmsController;
use Symfony\Component\HttpFoundation\Request;

class CmsController extends SprykerCmsController
{
    /**
     * @param array $data
     * @param \Generated\Shared\Transfer\LocaleCmsPageDataTransfer $localeCmsPageDataTransfer
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executePageAction($data, LocaleCmsPageDataTransfer $localeCmsPageDataTransfer, Request $request): array
    {
        $viewData = parent::executePageAction($data, $localeCmsPageDataTransfer, $request);
        $viewData[FirstSpiritPreviewConstants::VIEW_DATA_PAGE_TYPE_KEY] = FirstSpiritPreviewConstants::CMS_PAGE_TYPE;
        $viewData[FirstSpiritPreviewConstants::VIEW_DATA_PAGE_ID_KEY] = $localeCmsPageDataTransfer->getIdCmsPage();

        return $viewData;
    }
}
