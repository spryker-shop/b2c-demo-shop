<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Persistence;

use Orm\Zed\ContactUs\Persistence\PyzContactUsQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface getRepository()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\ContactUs\ContactUsConfig getConfig()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface getQueryContainer()
 */
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
