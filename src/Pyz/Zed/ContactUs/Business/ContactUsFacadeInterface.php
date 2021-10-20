<?php

namespace Pyz\Zed\ContactUs\Business;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsFacadeInterface
{
    /**
     * @return mixed
     */
    public function getContactUsData();

    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return mixed
     */
    public function saveContactUsData(ContactUsTransfer $contactUsTransfer);
}
