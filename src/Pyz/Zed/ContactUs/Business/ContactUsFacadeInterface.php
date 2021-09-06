<?php

namespace Pyz\Zed\ContactUs\Business;

use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsFacadeInterface
{

    /**
     * @param \Generated\Shared\Transfer\ContactUsTransfer $contactTransfer
     *
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function getContactUsData(ContactUsTransfer $contactTransfer);

    /**
     * @param ContactUsTransfer $contactTransfer
     *
     * @return \Generated\Shared\Transfer\ContactUsTransfer
     */
    public function saveContactUsData(ContactUsTransfer $contactTransfer);
}
