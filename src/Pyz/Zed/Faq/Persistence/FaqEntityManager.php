<?php

namespace Pyz\Zed\Faq\Persistence;

use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method FaqPersistenceFactory getFactory()
 */
class FaqEntityManager extends AbstractEntityManager implements FaqEntityManagerInterface {

    public function createFaqEntity(FaqTransfer $trans): FaqTransfer {

        return $this->updateFaqEntity($trans); // code redundancy
    }

    public function updateFaqEntity(FaqTransfer $trans): FaqTransfer {

        $ent = $this->getFactory()->createFaqQuery()
            ->filterByIdFaq($trans->getIdFaq())
            ->findOneOrCreate();

        $ent->fromArray($trans->toArray());
        $ent->save();

        $trans->fromArray($ent->toArray());
        return $trans;
    }

    public function deleteFaqEntity(FaqTransfer $trans): void {

        $this->getFactory()
            ->createFaqQuery()
            ->filterByIdFaq($trans->getIdFaq())
            ->delete();
    }
}
