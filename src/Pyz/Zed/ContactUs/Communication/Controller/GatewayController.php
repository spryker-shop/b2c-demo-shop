<?php

namespace Pyz\Zed\ContactUs\Communication\Controller;

use Generated\Shared\Transfer\ContactUsResponseTransfer;
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
     * @return \Generated\Shared\Transfer\ContactUsResponseTransfer
     */
    public function saveMessageAction(ContactUsTransfer $contactUsTransfer): ContactUsResponseTransfer
    {
        $saveResult = $this->getFacade()
            ->saveContactUsData($contactUsTransfer);

        return (new ContactUsResponseTransfer())->setIsSuccess($saveResult);
    }
}
