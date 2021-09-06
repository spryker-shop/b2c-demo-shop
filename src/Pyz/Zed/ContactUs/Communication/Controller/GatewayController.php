<?php

namespace Pyz\Zed\ContactUs\Communication\Controller;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Pyz\Zed\ContactUs\Business\ContactUsFacade getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return ContactUsTransfer
     */
    public function saveContactAction(ContactUsTransfer $contactUsTransfer):ContactUsTransfer
    {
        return $this->getFacade()->saveContactUsData($contactUsTransfer);
    }
}
