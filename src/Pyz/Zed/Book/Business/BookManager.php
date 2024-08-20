<?php
namespace Pyz\Zed\Book\Business;

use Generated\Shared\Transfer\BookTransfer;
use Pyz\Zed\Book\Persistence\BookEntityManagerInterface;
use Pyz\Zed\Book\Persistence\BookRepositoryInterface;

class BookManager
{
    protected $entityManager;
    protected $repository;

    public function __construct(BookEntityManagerInterface $entityManager, BookRepositoryInterface $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    // Adding a Book record
    public function createBook(BookTransfer $bookTransfer): BookTransfer
    {
        return $this->entityManager->saveBook($bookTransfer);
    }

    // Find a book by its ID
    public function findBookById(int $idBook): BookTransfer
    {
        return $this->repository->findBookById($idBook);
    }

    // Find all books
    public function findAllBooks(): array
    {
        return $this->repository->findAllBooks();
    }
}
