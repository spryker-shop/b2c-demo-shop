<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Persistence;

use Orm\Zed\ContactUs\Persistence\PyzContactUsQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * Class ContactUsQueryContainer
 *
 * @package Pyz\Zed\ContactUs\Persistence
 *
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsPersistenceFactory getFactory()
 */
class ContactUsQueryContainer extends AbstractQueryContainer implements ContactUsQueryContainerInterface
{
    public function queryContactUs(): PyzContactUsQuery
    {
        return $this->getFactory()->createContactUsQuery();
    }
}
