<?php

namespace Pyz\Zed\Faq\Business;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;

interface FaqFacadeInterface {

    public function createFaqEntity(FaqTransfer $trans): FaqTransfer;
    public function updateFaqEntity(FaqTransfer $trans): FaqTransfer;
    public function deleteFaqEntity(FaqTransfer $trans): void;

    public function findFaqEntityById(int $id): ?FaqTransfer;

    public function getFaqCollection(FaqCollectionTransfer $trans): FaqCollectionTransfer;
    public function getFaqEntity(FaqTransfer $trans): ?FaqTransfer;
}
