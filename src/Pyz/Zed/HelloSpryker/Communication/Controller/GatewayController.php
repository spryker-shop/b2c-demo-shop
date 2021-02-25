<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Communication\Controller;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Pyz\Zed\HelloSpryker\Business\HelloSprykerFacade getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    public function getContactUsDataAction()
    {
        return $this->getFacade()
            ->getContactUsData();
    }

    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsEntityTransfer
     *
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function saveContactUsDataAction(ContactUsTransfer $contactUsEntityTransfer): ContactUsTransfer
    {
        return $this->getFacade()->saveContactUsData($contactUsEntityTransfer);
    }
}
