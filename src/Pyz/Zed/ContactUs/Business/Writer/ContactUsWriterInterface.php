<?php

namespace Pyz\Zed\ContactUs\Business\Writer;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsWriterInterface
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     * @return ContactUsTransfer
     */
    public function saveContactUs(ContactUsTransfer $contactUsTransfer): ContactUsTransfer;
}
