<?php
namespace Pyz\Zed\Book\Business;

use Generated\Shared\Transfer\BookTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;
use Propel\Runtime\Collection\ObjectCollection;
use Orm\Zed\Book\Persistence\PyzBook;

/**
 * @method \Pyz\Zed\Book\Business\BookBusinessFactory getFactory()
 */
class BookFacade extends AbstractFacade implements BookFacadeInterface
{
    // For adding a book record
    public function createBook(BookTransfer $bookTransfer): BookTransfer
    {
        return $this->getFactory()->createBookManager()->createBook($bookTransfer);
    }

    // Update a book
    public function updateBook(int $idBook, BookTransfer $bookTransfer): BookTransfer
    {
        return $this->getEntityManager()->updateBook($idBook, $bookTransfer);
    }

    // Delete one book by Id
    public function deleteBook(int $idBook): void
    {
        $this->getEntityManager()->deleteBook($idBook);
    }

    // Find one Book Instance
    public function findBookById(int $idBook): PyzBook
    {
        return $this->getRepository()->findBookById($idBook);
    }

    // Find all books
    public function findAllBooks(): ObjectCollection
    {
        return $this->getRepository()->findAllBooks();
    }
}
