<?php


namespace Pyz\Zed\ContactUs\Business\Reader;


use Generated\Shared\Transfer\ContactUsTransfer;
use Orm\Zed\ContactUs\Persistence\PyzContactUs;
use Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface;

class ContactUsReader implements ContactUsReaderInterface
{
    /**
     * @var ContactUsRepositoryInterface
     */
    protected $contactUsRepository;

    /**
     * ContactUsReader constructor.
     * @param ContactUsRepositoryInterface $contactUsRepository
     */
    public function __construct(ContactUsRepositoryInterface $contactUsRepository)
    {
        $this->contactUsRepository = $contactUsRepository;
    }

    public function getContactUsMessages(): array
    {
        return array_map(function (PyzContactUs $contactUsEntity) {
            return $this->mapPyzEntityToTransfer($contactUsEntity);
        }, $this->contactUsRepository->getContactUsMessages());
    }

    public function findContactUsById(int $contactUsId): ?ContactUsTransfer
    {
        $contactUsEntity = $this->contactUsRepository->findContactUsById($contactUsId);

        if (is_null($contactUsEntity)) {
            return null;
        }

        return $this->mapPyzEntityToTransfer($contactUsEntity);
    }

    protected function mapPyzEntityToTransfer(PyzContactUs $contactUsEntity): ContactUsTransfer
    {
        return (new ContactUsTransfer())->fromArray($contactUsEntity->toArray());
    }
}
