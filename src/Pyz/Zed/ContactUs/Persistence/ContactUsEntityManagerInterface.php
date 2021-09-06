<?php


namespace Pyz\Zed\ContactUs\Persistence;


use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsEntityManagerInterface
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return ContactUsTransfer
     */
    public function saveContactUs(ContactUsTransfer $contactUsTransfer):ContactUsTransfer;
}
