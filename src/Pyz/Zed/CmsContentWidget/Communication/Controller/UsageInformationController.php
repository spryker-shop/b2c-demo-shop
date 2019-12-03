<?php


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
