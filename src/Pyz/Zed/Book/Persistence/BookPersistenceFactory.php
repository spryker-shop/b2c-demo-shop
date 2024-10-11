<?php

namespace Pyz\Zed\Book\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Orm\Zed\Book\Persistence\PyzBookQuery;

class BookPersistenceFactory extends AbstractPersistenceFactory
{
    // Instantiating PyzBookQuery for deleteBook BookEntityManager function
    public function createPyzBookQuery(): PyzBookQuery
    {
        return PyzBookQuery::create();
    }


    // Instantiating PyzBookQuery for findAllBooks and findBookById BookRepository functions
    public function getBookQuery(): PyzBookQuery
    {
        return PyzBookQuery::create();
    }

}
