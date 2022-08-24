<?php

namespace Pyz\Zed\Faq\Business\Deleter;

use Generated\Shared\Transfer\FaqTransfer;

interface FaqDeleterInterface {

    public function deleteFaqEntity(FaqTransfer $faqTransfer): void;
}
