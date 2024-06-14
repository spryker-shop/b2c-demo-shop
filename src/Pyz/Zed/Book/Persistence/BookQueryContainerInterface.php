<?php

namespace Pyz\Zed\Book\Persistence;

use Orm\Zed\Book\Persistence\PyzBookQuery;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface BookQueryContainerInterface extends QueryContainerInterface
{
   
    public function queryBooks(): PyzBookQuery;

    public function queryBookById(int $id): PyzBookQuery;
}
