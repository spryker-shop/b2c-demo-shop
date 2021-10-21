<?php

namespace Pyz\Client\ContactUs;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsClientInterface
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     */
    public function saveContactUs(ContactUsTransfer $contactUsTransfer);
}
