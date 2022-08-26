<?php

namespace Pyz\Client\Faq\Zed;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;

interface FaqZedStubInterface {
    public function getFaqCollection(FaqCollectionTransfer $faqCollectionTransfer): FaqCollectionTransfer;

    public function getFaqEntity(FaqTransfer $trans): ?FaqTransfer;

    public function createFaqEntity(FaqTransfer $trans): bool;
    public function deleteFaqEntity(FaqTransfer $trans): bool;
    public function updateFaqEntity(FaqTransfer $trans): bool;
}
