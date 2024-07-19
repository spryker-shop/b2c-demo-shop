<?php

namespace Pyz\Zed\Book\Communication;

use Orm\Zed\Book\Persistence\PyzBookQuery;
use Pyz\Zed\Book\Communication\Table\BookTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class BookCommunicationFactory extends AbstractCommunicationFactory
{
    public function createBookTable()
    {
        return new BookTable(new PyzBookQuery());
    }
}
