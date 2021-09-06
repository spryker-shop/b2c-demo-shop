<?php


namespace Pyz\Zed\ContactUs\Business\Reader;


use Generated\Shared\Transfer\ContactUsTransfer;
use Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface;

class ContactReader implements ContactReaderInterface
{
    /**
     * @var ContactUsRepositoryInterface
     */
    protected $contactRepository;

    /**
     * ContactReader constructor.
     *
     * @param ContactUsRepositoryInterface $contactRepository
     */
    public function __construct(ContactUsRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * @inheritDoc
     */
    public function getContact(ContactUsTransfer $contactTransfer): ?ContactUsTransfer
    {
        return $this->contactRepository->findContactById($contactTransfer->getIdContactUs());
    }
}
