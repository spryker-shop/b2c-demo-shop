<?php

namespace Pyz\Zed\Faq\Persistence;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;

interface FaqRepositoryInterface {

    public function findFaqEntityById(int $id): ?FaqTransfer;

    public function getFaqCollection(FaqCollectionTransfer $trans): FaqCollectionTransfer;
    public function getFaqCollectionPaginated(int $limit, int $page): FaqCollectionTransfer;
}
