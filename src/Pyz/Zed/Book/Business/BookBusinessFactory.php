<?php

namespace Pyz\Zed\Book\Business;

use Pyz\Zed\Book\Business\Mapper\BookMapper;
use Pyz\Zed\Book\Business\Mapper\BookMapperInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class BookBusinessFactory extends AbstractBusinessFactory
{
    public function createBookMapper(): BookMapperInterface
    {
        return new BookMapper();
    }
}
