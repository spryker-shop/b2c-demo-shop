<?php

namespace Pyz\Zed\Faq\Business\Deleter;

use Generated\Shared\Transfer\FaqTransfer;
use Pyz\Zed\Faq\Persistence\FaqEntityManagerInterface;

class FaqDeleter implements FaqDeleterInterface {

    protected FaqEntityManagerInterface $ent;

    public function __construct(FaqEntityManagerInterface $ent) {
        $this->ent = $ent;
    }

    public function deleteFaqEntity(FaqTransfer $faqTransfer): void {
        $this->ent->deleteFaqEntity($faqTransfer);
    }
}
