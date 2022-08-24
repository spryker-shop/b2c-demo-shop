<?php

namespace Pyz\Zed\Faq\Business\Writer;

use Generated\Shared\Transfer\FaqTransfer;
use Pyz\Zed\Faq\Persistence\FaqEntityManagerInterface;

class FaqWriter implements FaqWriterInterface {

    protected FaqEntityManagerInterface $ent;

    public function __construct(FaqEntityManagerInterface $ent) {
        $this->ent = $ent;
    }

    public function createFaqEntity(FaqTransfer $faqTransfer): FaqTransfer {

        return $this->ent
            ->createFaqEntity($faqTransfer);
    }
}
