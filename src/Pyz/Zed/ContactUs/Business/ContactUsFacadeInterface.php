<?php

namespace Pyz\Zed\ContactUs\Business;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsFacadeInterface
{
    /**
     *
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsTransfer
     *
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function saveContactUsData(ContactUsTransfer $contactUsTransfer): ContactUsTransfer;

    /**
     * @return array
     */
    public function getContactUsData(): array;
}
