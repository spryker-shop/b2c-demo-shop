<?php

namespace Pyz\Zed\Faq\Business\Reader;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Generated\Shared\Transfer\PaginationTransfer;

interface FaqReaderInterface {

    public function findFaqEntityById(int $id): ?FaqTransfer;
    public function getFaqCollection(FaqCollectionTransfer $trans): FaqCollectionTransfer;
    public function getFaqCollectionPaginated(PaginationTransfer $trans): FaqCollectionTransfer;
}
