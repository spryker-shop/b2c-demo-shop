<?php
namespace Pyz\Zed\Book\Persistence;

use Generated\Shared\Transfer\BookTransfer;
use Orm\Zed\Book\Persistence\PyzBook;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;
use Pyz\Zed\Book\Persistence\BookEntityManagerInterface;

// This class handles saving and deleting data from the database.
class BookEntityManager extends AbstractEntityManager implements BookEntityManagerInterface
{
    // Saving book record to the database
    public function saveBook(BookTransfer $bookTransfer): BookTransfer
    {
        $pyzBook = new PyzBook();
        $pyzBook->setName($bookTransfer->getName());
        $pyzBook->setDescription($bookTransfer->getDescription());
        $pyzBook->setPublicationDate($bookTransfer->getPublicationDate()->getDate());
        $pyzBook->save();

        $bookTransfer->setIdBook($pyzBook->getIdBook());

        return $bookTransfer;
    }

    private function convertEntityToTransfer($pyzBook)
    {
        $bookTransfer = new BookTransfer();
        $bookTransfer->fromArray($pyzBook->toArray(), true);
        return $bookTransfer;
    }

    // Updating a book record in the database
    public function updateBook(int $idBook, BookTransfer $bookTransfer): BookTransfer
    {
        $pyzBook = $this->getFactory()->getBookQuery()->findOneByIdBook($idBook);

        // $pyzBook = $this->convertEntityToTransfer($pyzBook);
    
        if ($pyzBook !== null) {
            if ($bookTransfer->getName() !== null) {
                $pyzBook->setName($bookTransfer->getName());
            }

            if ($bookTransfer->getDescription() !== null) {
                $pyzBook->setDescription($bookTransfer->getDescription());
            }
            
            if ($bookTransfer->getPublicationDate() !== null) {
                $pyzBook->setPublicationDate($bookTransfer->getPublicationDate()->getDate());
            }

            $pyzBook->save();

            // Convert the updated entity back to a transfer object if needed
            $updatedBookTransfer = $this->convertEntityToTransfer($pyzBook);

            return $updatedBookTransfer;
        }
    }

    // Delete book record from the database
    public function deleteBook(int $idBook): void
    {
        $bookEntity = $this->getFactory()->createPyzBookQuery()->findOneByIdBook($idBook);
        if ($bookEntity !== null) {
            $bookEntity->delete();
        }
    }
}
