<?php

namespace Pyz\Zed\Faq\Communication\Controller;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Pyz\Zed\Faq\Business\FaqFacade;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method FaqFacade getFacade()
 */
class GatewayController extends AbstractGatewayController {

    public function getFaqCollectionAction(FaqCollectionTransfer $trans): FaqCollectionTransfer {

        return $this->getFacade()
            ->getFaqCollection($trans);
    }

    public function getFaqEntityAction(FaqTransfer $trans): ?FaqTransfer {

        return $this->getFacade()
            ->getFaqEntity($trans);
    }

    public function updateFaqEntityAction(FaqTransfer  $trans): FaqTransfer {

    }
}
