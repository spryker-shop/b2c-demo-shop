<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Communication\Controller;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * Class GatewayController
 *
 * @package Pyz\Zed\ContactUs\Communication\Controller
 *
 * @method \Pyz\Zed\ContactUs\Business\ContactUsFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    public function addAction(ContactUsTransfer $contactUsTransfer)
    {
        $contactUsTransfer->setIsProcessed(false);

        return $this->getFacade()->saveContactUs($contactUsTransfer);
    }
}
