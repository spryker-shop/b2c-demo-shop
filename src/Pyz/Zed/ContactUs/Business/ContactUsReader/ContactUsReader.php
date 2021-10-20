<?php

namespace Pyz\Zed\ContactUs\Business\ContactUsReader;

use Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface;

class ContactUsReader implements ContactUsReaderInterface
{
    /**
     * @var \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface
     */
    protected $contactUsRepository;

    /**
     * @param \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface $antelopeRepository
     */
    public function __construct(ContactUsRepositoryInterface $antelopeRepository)
    {
        $this->contactUsRepository = $antelopeRepository;
    }

    /**
     * @return mixed|\Orm\Zed\ContactUs\Persistence\PyzContactUs[]
     */
    public function getContactUsEntities()
    {
        return $this->contactUsRepository->getContactUsList();
    }
}
