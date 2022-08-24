<?php

namespace Pyz\Zed\Faq\Business\Updater;

use Generated\Shared\Transfer\FaqTransfer;
use Pyz\Zed\Faq\Business\Writer\FaqWriterInterface;
use Pyz\Zed\Faq\Persistence\FaqEntityManagerInterface;

class FaqUpdater implements FaqUpdaterInterface {


    protected FaqEntityManagerInterface $ent;

    public function __construct(FaqEntityManagerInterface $ent) {
        $this->ent = $ent;
    }

    public function updateFaqEntity(FaqTransfer $faqTransfer): FaqTransfer {

        return $this->ent->updateFaqEntity($faqTransfer);
    }
}
