<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\HelloSpryker\Zed;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

/**
 * Class HelloSprykerStub
 *
 * @package Pyz\Client\HelloSpryker\Zed
 */
class HelloSprykerStub extends ZedRequestStub implements HelloSprykerStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsEntityTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function saveContactUsData(ContactUsTransfer $contactUsEntityTransfer): TransferInterface
    {
        return $this->zedStub->call(
            '/hello-spryker/gateway/save-contact-us-data',
            $contactUsEntityTransfer
        );
    }
}
