<?php

namespace Pyz\Client\ContactUs;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsClientInterface
{
    public function addContactUsFeedback(ContactUsTransfer $contactUsTransfer): ContactUsTransfer;
}
