<?php

namespace Pyz\Zed\Faq\Business\Updater;

use Generated\Shared\Transfer\FaqTransfer;

interface FaqUpdaterInterface {

    public function updateFaqEntity(FaqTransfer $faqTransfer): FaqTransfer;
}
