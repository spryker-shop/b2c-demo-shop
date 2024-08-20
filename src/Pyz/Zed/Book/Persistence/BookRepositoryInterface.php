<?php
namespace Pyz\Zed\Book\Persistence;

use Propel\Runtime\Collection\ObjectCollection;
use Orm\Zed\Book\Persistence\PyzBook;

interface BookRepositoryInterface
{
    // Find all books
    public function findAllBooks(): ObjectCollection;

    // Find a book by id
    public function findBookById(int $idBook): PyzBook;
}
