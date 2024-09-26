<?php

namespace Pyz\Zed\Book\Business\Mapper;

use Orm\Zed\Book\Persistence\PyzBook;
use Pyz\Zed\Book\BookTransfer;

interface BookMapperInterface
{
    public function mapEntityToTransfer(PyzBook $bookEntity): BookTransfer;
    public function mapTransferToEntity(BookTransfer $bookTransfer, PyzBook $bookEntity): PyzBook;
}
