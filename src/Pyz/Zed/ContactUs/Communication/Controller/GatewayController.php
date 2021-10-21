<?php

namespace Pyz\Zed\ContactUs\Communication\Controller;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\ContactUs\Business\ContactUsFacade getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     */
    public function storeAction(ContactUsTransfer $contactUsTransfer)
    {
        $this->getFacade()->saveContactUsData($contactUsTransfer);
    }
}
