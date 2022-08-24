<?php

namespace Pyz\Zed\Faq\Business\Writer;

use Generated\Shared\Transfer\FaqTransfer;

interface FaqWriterInterface {

    public function createFaqEntity(FaqTransfer $faqTransfer): FaqTransfer;
}
