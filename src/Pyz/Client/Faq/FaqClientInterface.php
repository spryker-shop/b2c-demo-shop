<?php

namespace Pyz\Client\Faq;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;

interface FaqClientInterface
{
    /**
     * @api
     * @return \Generated\Shared\Transfer\FaqCollectionTransfer
     */
    public function getFaqCollection(): FaqCollectionTransfer;

    public function getFaqEntity(FaqTransfer $trans): ?FaqTransfer;

    public function createFaqEntity(FaqTransfer $trans): bool;
    public function deleteFaqEntity(FaqTransfer $trans): bool;
    public function updateFaqEntity(FaqTransfer $trans): bool;
}
