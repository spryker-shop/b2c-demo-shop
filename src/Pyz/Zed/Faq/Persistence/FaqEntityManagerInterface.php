<?php

namespace Pyz\Zed\Faq\Persistence;

use Generated\Shared\Transfer\FaqTransfer;

interface FaqEntityManagerInterface {

    public function createFaqEntity(FaqTransfer $trans): FaqTransfer;
    public function updateFaqEntity(FaqTransfer $trans): FaqTransfer;
    public function deleteFaqEntity(FaqTransfer $trans): void;
}
