<?php

namespace Pyz\Zed\Faq\Business\Deleter;

use Pyz\Zed\Faq\Persistence\FaqEntityManagerInterface;

class FaqDeleter implements FaqDeleterInterface {

    protected FaqEntityManagerInterface $ent;

    public function __construct(FaqEntityManagerInterface $ent) {
        $this->ent = $ent;
    }
}
