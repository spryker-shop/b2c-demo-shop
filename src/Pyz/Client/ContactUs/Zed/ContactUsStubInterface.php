<?php

namespace Pyz\Client\ContactUs\Zed;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

interface ContactUsStubInterface {

    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function addMessage(ContactUsTransfer $contactUsTransfer): TransferInterface;

}
