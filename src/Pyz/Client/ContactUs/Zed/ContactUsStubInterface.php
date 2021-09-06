<?php

namespace Pyz\Client\ContactUs\Zed;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsStubInterface
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return ContactUsTransfer
     */
    public function saveContact(ContactUsTransfer $contactUsTransfer):ContactUsTransfer;
}
