<?php


/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence;

use Orm\Zed\Book\Persistence\PyzBookQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\Book\Persistence\BookQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class BookPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Book\Persistence\PyzBookQuery
     */
    public function createPyzBookQuery()
    {
        return PyzBookQuery::create();
    }
}
