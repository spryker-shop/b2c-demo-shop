<?php


namespace Pyz\Zed\ContactUs\Persistence;


use Orm\Zed\ContactUs\Persistence\PyzContactUsQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * Class ContactUsQueryContainer
 * @package Pyz\Zed\ContactUs\Persistence
 *
 * @method ContactUsPersistenceFactory getFactory()
 */
class ContactUsQueryContainer extends AbstractQueryContainer implements ContactUsQueryContainerInterface
{

    public function queryContactUs(): PyzContactUsQuery
    {
        return $this->getFactory()->createContactUsQuery();
    }
}
