<?php

namespace Pyz\Client\Faq;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\PaginationTransfer;

interface FaqClientInterface {

    public function getAllFaqs(PaginationTransfer $pagination): FaqCollectionTransfer;
}
