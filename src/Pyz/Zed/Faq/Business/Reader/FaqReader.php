<?php

namespace Pyz\Zed\Faq\Business\Reader;

use Pyz\Zed\Faq\Persistence\FaqRepositoryInterface;

class FaqReader implements FaqReaderInterface {

    protected FaqRepositoryInterface $repo;

    public function __construct(FaqRepositoryInterface $repo) {
        $this->repo = $repo;
    }
}
