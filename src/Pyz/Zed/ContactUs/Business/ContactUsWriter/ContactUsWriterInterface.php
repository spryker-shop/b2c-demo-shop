<?php

namespace Pyz\Zed\ContactUs\Business\ContactUsWriter;

use Generated\Shared\Transfer\ContactUsTransfer;
use Generated\Shared\Transfer\PyzContactUsEntityTransfer;

interface ContactUsWriterInterface
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return PyzContactUsEntityTransfer
     */
    public function saveContactUsData(ContactUsTransfer $contactUsTransfer): PyzContactUsEntityTransfer;
}
