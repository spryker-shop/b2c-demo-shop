<?php


namespace Pyz\Zed\ContactUs\Communication\Controller;


use Generated\Shared\Transfer\ContactUsTransfer;
use Pyz\Zed\ContactUs\Business\ContactUsFacadeInterface;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * Class GatewayController
 * @package Pyz\Zed\ContactUs\Communication\Controller
 *
 * @method ContactUsFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    public function addAction(ContactUsTransfer $contactUsTransfer)
    {
        return $this->getFacade()->saveContactUs($contactUsTransfer);
    }
}
