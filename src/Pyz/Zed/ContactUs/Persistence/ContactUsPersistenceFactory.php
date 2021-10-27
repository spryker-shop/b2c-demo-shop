<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Orm\Zed\ContactUs\Persistence\PyzContactUsQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class ContactUsPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ContactUs\Persistence\PyzContactUsQuery
     */
    public function createContactUsQuery(): PyzContactUsQuery
    {
        return PyzContactUsQuery::create();
    }
}
