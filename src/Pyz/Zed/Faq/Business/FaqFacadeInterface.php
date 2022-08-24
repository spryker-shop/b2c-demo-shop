<?php

namespace Pyz\Zed\Faq\Business;

use Generated\Shared\Transfer\FaqTransfer;

interface FaqFacadeInterface {

    public function createFaqEntity(FaqTransfer $trans): FaqTransfer;
    public function updateFaqEntity(FaqTransfer $trans): FaqTransfer;
    public function deleteFaqEntity(FaqTransfer $trans): void;

    public function findFaqEntityById(int $id): ?FaqTransfer;
}
