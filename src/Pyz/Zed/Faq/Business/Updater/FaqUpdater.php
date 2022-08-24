<?php

namespace Pyz\Zed\Faq\Business\Updater;

use Pyz\Zed\Faq\Business\Writer\FaqWriterInterface;
use Pyz\Zed\Faq\Persistence\FaqEntityManagerInterface;

class FaqUpdater implements FaqUpdaterInterface {


    protected FaqEntityManagerInterface $ent;

    public function __construct(FaqEntityManagerInterface $ent) {
        $this->ent = $ent;
    }
}
