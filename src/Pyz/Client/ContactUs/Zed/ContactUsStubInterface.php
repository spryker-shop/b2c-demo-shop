<?php

namespace Pyz\Client\ContactUs\Zed;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsStubInterface
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     */
    public function saveContactUs(ContactUsTransfer $contactUsTransfer);
}
