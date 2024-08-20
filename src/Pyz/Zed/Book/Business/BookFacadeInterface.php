<?php
namespace Pyz\Zed\Book\Business;

use Generated\Shared\Transfer\BookTransfer;
use Propel\Runtime\Collection\ObjectCollection;
use Orm\Zed\Book\Persistence\PyzBook;

interface BookFacadeInterface
{
    public function createBook(BookTransfer $bookTransfer): BookTransfer;

    public function updateBook(int $idBook, BookTransfer $bookTransfer): BookTransfer;

    public function deleteBook(int $idBook): void;

    public function findBookById(int $idBook): PyzBook;
    
    public function findAllBooks(): ObjectCollection;
}
