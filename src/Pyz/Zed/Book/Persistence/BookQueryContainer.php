<?php

namespace Pyz\Zed\Book\Persistence;

use Orm\Zed\Book\Persistence\PyzBookQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

class BookQueryContainer extends AbstractQueryContainer implements BookQueryContainerInterface
{
    
    public function queryBooks(): PyzBookQuery
    {
        return PyzBookQuery::create();
    }

   
    public function queryBookById(int $id): PyzBookQuery
    {
        return PyzBookQuery::create()->filterByIdPyzBook($id);
    }
}
