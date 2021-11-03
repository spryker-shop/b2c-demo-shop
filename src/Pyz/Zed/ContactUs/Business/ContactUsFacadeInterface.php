<?php

namespace Pyz\Zed\ContactUs\Business;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsTransfer
     *
     * @return bool
     */
    public function saveContactUsData(ContactUsTransfer $contactUsTransfer): bool;

    /**
     * @return array
     */
    public function getContactUsData(): array;
}
