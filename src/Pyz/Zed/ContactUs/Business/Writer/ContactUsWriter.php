<?php


namespace Pyz\Zed\ContactUs\Business\Writer;


use Generated\Shared\Transfer\ContactUsTransfer;
use Pyz\Zed\ContactUs\Business\Writer\ContactWriterInterface;
use Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface;

class ContactUsWriter implements ContactWriterInterface
{
    /**
     * @var ContactUsEntityManagerInterface
     */
    protected $contactUsEntityManager;

    public function __construct(ContactUsEntityManagerInterface $contactUsEntityManager)
    {
        $this->contactUsEntityManager = $contactUsEntityManager;
    }

    public function saveContact(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        return $this->contactUsEntityManager->saveContactUs($contactUsTransfer);
    }
}
