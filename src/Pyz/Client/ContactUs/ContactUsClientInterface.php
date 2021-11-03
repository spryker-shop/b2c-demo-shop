<?php

namespace Pyz\Client\ContactUs;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsClientInterface {

    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    public function addMessage(ContactUsTransfer $contactUsTransfer);
}

