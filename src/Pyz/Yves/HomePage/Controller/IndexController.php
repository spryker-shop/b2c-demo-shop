<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\HomePage\Controller;

use ESpirit\Shared\FirstSpiritPreview\FirstSpiritPreviewConstants;
use SprykerShop\Yves\HomePage\Controller\IndexController as SprykerIndexController;

class IndexController extends SprykerIndexController
{
    /**
     * @return array
     */
    protected function executeIndexAction(): array
    {
        $viewData = parent::executeIndexAction();
        $viewData[FirstSpiritPreviewConstants::VIEW_DATA_PAGE_ID_KEY] = 'homepage';
        $viewData[FirstSpiritPreviewConstants::VIEW_DATA_PAGE_TYPE_KEY] = FirstSpiritPreviewConstants::STATIC_PAGE_TYPE;

        return $viewData;
    }
}
