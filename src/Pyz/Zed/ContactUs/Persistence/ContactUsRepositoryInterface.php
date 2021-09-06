<?php


namespace Pyz\Zed\ContactUs\Persistence;


use Generated\Shared\Transfer\ContactUsTransfer;

interface ContactUsRepositoryInterface
{
    /**
     * @param int $idContact
     *
     * @return ContactUsTransfer|null
     */
    public function findContactById(int $idContact): ?ContactUsTransfer;
}
