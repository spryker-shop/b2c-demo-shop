<?php
namespace Pyz\Zed\Book\Business;

use  Pyz\Zed\Book\BookTransfer;
use Orm\Zed\Book\Persistence\PyzBook;

class BookFacade
{
    
    public function findAllBooks()
    {

        return \Orm\Zed\Book\Persistence\PyzBookQuery::create()->find();
    }

    public function createBook(BookTransfer $bookTransfer)
{
    $bookEntity = new PyzBook();
    $bookEntity->fromArray($bookTransfer->toArray());

    if ($bookTransfer->getName()) {
        $bookEntity->setName($bookTransfer->getName());
    } else {
        throw new \Exception('Name is required.');
    }

    if ($bookTransfer->getDescription()) {
        $bookEntity->setDescription($bookTransfer->getDescription());
    } else {
        throw new \Exception('Description is required.');
    }

    if ($bookTransfer->getPublicationDate()) {
        $bookEntity->setPublicationDate($bookTransfer->getPublicationDate());
    } else {
        throw new \Exception('Publication Date is required.');
    }
    
    $bookEntity->save();
}


    public function findBookById(int $id)
    {
        return \Orm\Zed\Book\Persistence\PyzBookQuery::create()->findPk($id);
    }

    public function updateBook(BookTransfer $bookTransfer)
{
    $bookEntity = \Orm\Zed\Book\Persistence\PyzBookQuery::create()->findPk($bookTransfer->getIdBook());

    if ($bookEntity) {
        if ($bookTransfer->getName() !== $bookEntity->getName()) {
            $bookEntity->setName($bookTransfer->getName());
        }

        if ($bookTransfer->getDescription() !== $bookEntity->getDescription()) {
            $bookEntity->setDescription($bookTransfer->getDescription());
        }

        if ($bookTransfer->getPublicationDate() !== $bookEntity->getPublicationDate()) {
            $bookEntity->setPublicationDate($bookTransfer->getPublicationDate());
        }

        $bookEntity->setUpdatedAt(new \DateTime());

        $bookEntity->save();
    }
}


   
    public function deleteBook(int $id): void
    {
        $bookEntity = \Orm\Zed\Book\Persistence\PyzBookQuery::create()->findPk($id);
        if ($bookEntity) {
            $bookEntity->delete();
        } else {
            throw new \Exception("Book with ID $id not found.");
        }
    }
   
}
