<?php

namespace Pyz\Zed\Book\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class BookBusinessFactory extends AbstractBusinessFactory
{
    public function createBookEntity()
    {
        return new \Orm\Zed\Book\Persistence\PyzBook();
    }
}
