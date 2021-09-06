<?php

namespace Pyz\Zed\ContactUs\Persistence;

use Orm\Zed\ContactUs\Persistence\PyzContactUsQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface ContactUsQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @return PyzContactUsQuery
     */
    public function queryContacts(): PyzContactUsQuery;
}
