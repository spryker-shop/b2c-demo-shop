<?php

namespace Pyz\Zed\ContactUs\Persistence;



use Orm\Zed\ContactUs\Persistence\PyzContactUs;

interface ContactUsRepositoryInterface
{
    /**
     * @return PyzContactUs[]
     */
    public function getContactUsMessages(): array;

    /**
     * @param int $contactUsId
     * @return PyzContactUs|null
     */
    public function findContactUsById(int $contactUsId): ?PyzContactUs;
}
