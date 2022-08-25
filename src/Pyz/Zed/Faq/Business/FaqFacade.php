<?php

namespace Pyz\Zed\Faq\Business;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method FaqBusinessFactory getFactory()
 */
class FaqFacade extends AbstractFacade implements FaqFacadeInterface {

    public function createFaqEntity(FaqTransfer $trans): FaqTransfer {

        return $this->getFactory()
            ->createFaqWriter()
            ->createFaqEntity($trans);
    }

    public function updateFaqEntity(FaqTransfer $trans): FaqTransfer {

        return $this->getFactory()
            ->createFaqUpdater()
            ->updateFaqEntity($trans);
    }

    public function deleteFaqEntity(FaqTransfer $trans): void {

        $this->getFactory()
            ->createFaqDeleter()
            ->deleteFaqEntity($trans);
    }

    public function findFaqEntityById(int $id): ?FaqTransfer {

        return $this->getFactory()
            ->createFaqReader()
            ->findFaqEntityById($id);
    }

    public function getFaqCollection(FaqCollectionTransfer $trans): FaqCollectionTransfer {

        return $this->getFactory()
            ->createFaqReader()
            ->getFaqCollection($trans);
    }

    public function getFaqEntity(FaqTransfer $trans): ?FaqTransfer {

        $res = $this->findFaqEntityById($trans->getIdFaq());

        if($res === null) {
            return null;
        }

        return $trans->fromArray($res->toArray());
    }
}
