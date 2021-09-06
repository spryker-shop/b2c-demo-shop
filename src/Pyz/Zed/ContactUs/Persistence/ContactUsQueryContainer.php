<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Orm\Zed\ContactUs\Persistence\PyzContactUsQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsPersistenceFactory getFactory()
 */
class ContactUsQueryContainer extends AbstractQueryContainer implements ContactUsQueryContainerInterface
{
    /**
     * @return PyzContactUsQuery
     */
    public function queryContacts(): PyzContactUsQuery
    {
        return $this->getFactory()->createPyzContactUsQuery();
    }
}
