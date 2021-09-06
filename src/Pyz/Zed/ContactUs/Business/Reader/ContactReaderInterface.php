<?php


namespace Pyz\Zed\ContactUs\Business\Reader;


use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactReaderInterface
{
    /**
     * @param ContactUsTransfer $contactTransfer
     *
     * @return ContactUsTransfer|null
     */
    public function getContact(ContactUsTransfer $contactTransfer): ?ContactUsTransfer;
}
