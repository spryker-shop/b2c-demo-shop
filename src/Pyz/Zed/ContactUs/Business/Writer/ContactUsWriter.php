<?php


namespace Pyz\Zed\ContactUs\Business\Writer;


use Generated\Shared\Transfer\ContactUsTransfer;
use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface;

class ContactUsWriter implements ContactUsWriterInterface
{
    /**
     * @var ContactUsEntityManagerInterface
     */
    protected $contactUsEntityManager;

    /**
     * ContactUsWriter constructor.
     * @param ContactUsEntityManagerInterface $contactUsEntityManager
     */
    public function __construct(ContactUsEntityManagerInterface $contactUsEntityManager)
    {
        $this->contactUsEntityManager = $contactUsEntityManager;
    }

    /**
     * @param ContactUsTransfer $contactUsTransfer
     * @return ContactUsTransfer
     */
    public function saveContactUs(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        $pyzContactUsEntityTransfer = $this->mapTransferToEntityTransfer($contactUsTransfer);
        $pyzContactUsEntityTransfer = $this->contactUsEntityManager->saveContactUs($pyzContactUsEntityTransfer);
        return $this->mapEntityTransferToTransfer($pyzContactUsEntityTransfer);
    }

    protected function mapTransferToEntityTransfer(ContactUsTransfer $contactUsTransfer): PyzContactUsEntityTransfer
    {
        $pyzContactUsEntityTransfer = new PyzContactUsEntityTransfer();
        $pyzContactUsEntityTransfer->fromArray($contactUsTransfer->toArray());
        return $pyzContactUsEntityTransfer;
    }

    protected function mapEntityTransferToTransfer(PyzContactUsEntityTransfer $pyzContactUsEntityTransfer): ContactUsTransfer
    {
        return (new ContactUsTransfer())->fromArray($pyzContactUsEntityTransfer->toArray());
    }
}
