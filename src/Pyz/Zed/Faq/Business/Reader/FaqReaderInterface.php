<?php

namespace Pyz\Zed\Faq\Business\Reader;

use Generated\Shared\Transfer\FaqTransfer;

interface FaqReaderInterface {

    public function findFaqEntityById(int $id): ?FaqTransfer;
}
