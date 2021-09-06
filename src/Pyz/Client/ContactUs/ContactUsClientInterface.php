<?php

namespace Pyz\Client\ContactUs;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsClientInterface
{
    /**
     *
     * @api
     *
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return ContactUsTransfer
     */
    public function saveContact(ContactUsTransfer $contactUsTransfer):ContactUsTransfer;
}
