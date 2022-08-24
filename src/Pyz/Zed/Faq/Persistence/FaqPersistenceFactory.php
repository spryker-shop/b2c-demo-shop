<?php

namespace Pyz\Zed\Faq\Persistence;

use Orm\Zed\Planet\Persistence\PyzFaqQuery;

class FaqPersistenceFactory {

    public function createFaqQuery(): PyzFaqQuery {

        return new PyzFaqQuery();
    }
}
