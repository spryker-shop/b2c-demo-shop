<?php


namespace Pyz\Zed\ContactUs\Business\Writer;


use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactWriterInterface
{
    public function saveContact(ContactUsTransfer $contactUsTransfer): ContactUsTransfer;
}
