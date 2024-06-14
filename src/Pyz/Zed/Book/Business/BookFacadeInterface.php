<?php

namespace Pyz\Zed\Book\Business;

use Generated\Shared\Transfer\PyzBookTransfer;

interface BookFacadeInterface
{
    public function createBook(PyzBookTransfer $bookTransfer);

    public function updateBook(PyzBookTransfer $bookTransfer);
    
    public function deleteBook($id);
}
