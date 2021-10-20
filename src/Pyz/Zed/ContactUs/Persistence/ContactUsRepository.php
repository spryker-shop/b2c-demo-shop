<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsPersistenceFactory getFactory()
 */
class ContactUsRepository extends AbstractRepository implements ContactUsRepositoryInterface
{
    /**
     * @return \Orm\Zed\ContactUs\Persistence\PyzContactUs[]
     */
    public function getContactUsList(): array
    {
        $contactUsEntities = $this->getFactory()
            ->createPyzContactUsQuery()
            ->find()
            ->toArray();

        return array_map(function ($entity) {
            return (new PyzContactUsEntityTransfer())->fromArray($entity);
        }, $contactUsEntities);
    }
}
