<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Generated\Shared\Transfer\ContactUsTransfer;


/**
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsPersistenceFactory getFactory()
 */
class ContactUsRepository extends AbstractRepository implements ContactUsRepositoryInterface
{
    /**
     *
     * @return \Orm\Zed\ContactUs\Persistence\PyzContactUs[]
     */
    public function findPyzContactUs(): array
    {
        $contactUsCollection = $this->getFactory()
            ->createContactUsQuery()
            ->find();

        if (!empty($contactUsCollection)) {
            $collection = [];
            foreach ($contactUsCollection as $contactUsEntity) {
                $collection[] = (new ContactUsTransfer())
                    ->fromArray($contactUsEntity->toArray(), true);
            }

            return $collection;
        }

        return $contactUsCollection;
    }


}
