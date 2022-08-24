<?php

namespace Pyz\Zed\Faq\Business\Writer;

use Pyz\Zed\Faq\Persistence\FaqEntityManagerInterface;

class FaqWriter implements FaqWriterInterface {

    protected FaqEntityManagerInterface $ent;

    public function __construct(FaqEntityManagerInterface $ent) {
        $this->ent = $ent;
    }
}
