<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Orm\Zed\ContactUs\Persistence\PyzContactUsQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\ContactUs\ContactUsConfig getConfig()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainer getQueryContainer()
 */
class ContactUsPersistenceFactory extends AbstractPersistenceFactory
{
    /**
    * @return PyzContactUsQuery
    */
    public function createPyzContactUsQuery()
    {
        return PyzContactUsQuery::create();
    }
}
