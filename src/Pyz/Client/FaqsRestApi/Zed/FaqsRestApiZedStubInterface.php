<?php

namespace Pyz\Client\FaqsRestApi\Zed;

use Generated\Shared\Transfer\FaqCollectionTransfer;

interface FaqsRestApiZedStubInterface {
    public function getFaqCollection(
        FaqCollectionTransfer $faqCollectionTransfer
    ): FaqCollectionTransfer;
}
