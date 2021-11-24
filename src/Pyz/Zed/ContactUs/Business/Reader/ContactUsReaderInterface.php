<?php

namespace Pyz\Zed\ContactUs\Business\Reader;


use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsReaderInterface
{
    /**
     * @return ContactUsTransfer[]
     */
    public function getContactUsMessages(): array;

    /**
     * @param int $contactUsId
     * @return null|ContactUsTransfer
     */
    public function findContactUsById(int $contactUsId): ?ContactUsTransfer;
}
