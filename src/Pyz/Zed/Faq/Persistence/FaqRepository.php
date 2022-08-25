<?php

namespace Pyz\Zed\Faq\Persistence;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method FaqPersistenceFactory getFactory()
 */
class FaqRepository extends AbstractRepository implements FaqRepositoryInterface {

    public function findFaqEntityById(int $id): ?FaqTransfer {

        $data = $this->getFactory()
            ->createFaqQuery()
            ->filterByIdFaq($id)
            ->findOne();

       if($data === null) {
           return null;
       }

       return (new FaqTransfer())->fromArray(
           $data->toArray(),
           true,
       );
    }

    public function getFaqCollection(FaqCollectionTransfer $trans): FaqCollectionTransfer {

        $data = $this->getFactory()
            ->createFaqQuery()
            ->find();

        foreach ($data->getData() as $faq) {
            $faq = (new FaqTransfer())
                ->fromArray($faq->toArray());

            $trans->addFaq($faq);
        }

        return $trans;
    }
}
