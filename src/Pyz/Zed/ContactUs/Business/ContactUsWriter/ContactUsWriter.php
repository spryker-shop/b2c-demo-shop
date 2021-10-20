<?php

namespace Pyz\Zed\ContactUs\Business\ContactUsWriter;

use Generated\Shared\Transfer\ContactUsTransfer;
use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface;

class ContactUsWriter implements ContactUsWriterInterface
{
    protected $contactUsEntityManager;

    public function __construct(ContactUsEntityManagerInterface $contactUsEntityManager)
    {
        $this->contactUsEntityManager = $contactUsEntityManager;
    }

    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return PyzContactUsEntityTransfer
     */
    public function saveContactUsData(ContactUsTransfer $contactUsTransfer): PyzContactUsEntityTransfer
    {
        $contactUsEntityTransfer = new PyzContactUsEntityTransfer();
        $contactUsEntityTransfer->fromArray($contactUsTransfer->toArray());

        return $this->contactUsEntityManager->saveContactUs($contactUsEntityTransfer);
    }
}
