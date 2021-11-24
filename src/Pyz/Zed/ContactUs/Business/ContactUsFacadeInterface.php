<?php


namespace Pyz\Zed\ContactUs\Business;


use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsFacadeInterface
{
    /**
     * @return ContactUsTransfer[]
     */
    public function getContactUsMessages(): array;

    /**
     * @param int $contactUsId
     * @return ContactUsTransfer
     */
    public function findContactUsById(int $contactUsId): ?ContactUsTransfer;

    /**
     * @param ContactUsTransfer $contactUsTransfer
     * @return ContactUsTransfer
     */
    public function saveContactUs(ContactUsTransfer $contactUsTransfer): ContactUsTransfer;
}
