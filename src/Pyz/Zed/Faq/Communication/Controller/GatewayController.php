<?php

namespace Pyz\Zed\Faq\Communication\Controller;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

class GatewayController extends AbstractGatewayController {

    public function getFaqCollectionAction(
        FaqCollectionTransfer $trans
    ): FaqCollectionTransfer {

        return $trans;
    }
}
