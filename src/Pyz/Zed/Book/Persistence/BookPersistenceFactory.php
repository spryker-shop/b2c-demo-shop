<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence;

use Orm\Zed\Book\Persistence\PyzBookQuery;
use Pyz\Zed\Book\Persistence\Mapper\BookMapper;
use Pyz\Zed\Book\Persistence\Mapper\BookMapperInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\Book\BookConfig getConfig()
 * @method \Pyz\Zed\Book\Persistence\BookEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class BookPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Book\Persistence\PyzBookQuery
     */
    public function createBookQuery(): PyzBookQuery
    {
        return PyzBookQuery::create();
    }

    /**
     * @return \Pyz\Zed\Book\Persistence\Mapper\BookMapperInterface
     */
    public function createBookMapper(): BookMapperInterface
    {
        return new BookMapper();
    }
}
