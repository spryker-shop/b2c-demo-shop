<?php
namespace Pyz\Zed\Book\Business;

use Orm\Zed\Book\Persistence\PyzBook;
use Generated\Shared\Transfer\BookTransfer;

interface BookManagerInterface
{
    public function createBook(BookTransfer $bookTransfer): BookTransfer;

    public function updateBook(PyzBook $bookTransfer): PyzBook;

    public function deleteBook(int $idBook);

    
    public function findBookById(int $idBook): BookTransfer;

    
    public function getAllBooks(): array;
}
