<?php

namespace Pyz\Zed\Faq\Persistence;

use Generated\Shared\Transfer\FaqTransfer;

interface FaqRepositoryInterface {

    public function findFaqEntityById(int $id): ?FaqTransfer;
}
