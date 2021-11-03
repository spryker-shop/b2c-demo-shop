<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsTransfer
     *
     * Returns true if the message was saved
     * @return bool
     */
    public function saveContactUsEntity(ContactUsTransfer $contactUsTransfer): bool;
}
