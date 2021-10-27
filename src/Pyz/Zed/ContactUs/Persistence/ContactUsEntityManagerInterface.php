<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactUsTransfer
     *
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function saveContactUsEntity(ContactUsTransfer $contactUsTransfer): ContactUsTransfer;
}
