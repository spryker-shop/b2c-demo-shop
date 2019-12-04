<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CmsContentWidget\Communication\Controller;

use Spryker\Zed\CmsContentWidget\Communication\Controller\UsageInformationController as SprykerUsageInformationController;

class UsageInformationController extends SprykerUsageInformationController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        return [
            'cmsContentWidgetTemplateList' => [],
        ];
    }
}
