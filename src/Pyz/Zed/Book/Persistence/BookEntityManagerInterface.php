<?php
namespace Pyz\Zed\Book\Persistence;

use Orm\Zed\Book\Persistence\PyzBook;
use Generated\Shared\Transfer\BookTransfer;

interface BookEntityManagerInterface
{
    // Saving data to the database
    public function saveBook(BookTransfer $bookTransfer): BookTransfer;


    // Updating the data in the database
    public function updateBook(int $idBook, BookTransfer $pyzBook): BookTransfer;

    // Delete a record in the database
    public function deleteBook(int $idBook): void;
}
