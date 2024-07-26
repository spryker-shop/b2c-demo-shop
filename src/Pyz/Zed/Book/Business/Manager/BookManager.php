<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Business\Manager;

use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Pyz\Zed\Book\Persistence\BookEntityManagerInterface;
use Pyz\Zed\Book\Persistence\BookRepositoryInterface;

class BookManager implements BookManagerInterface
{
    /**
     * @var \Pyz\Zed\Book\Persistence\BookRepositoryInterface
     */
    protected $bookRepository;

    /**
     * @var \Pyz\Zed\Book\Persistence\BookEntityManagerInterface
     */
    protected $bookEntityManager;

    /**
     * @param \Pyz\Zed\Book\Persistence\BookRepositoryInterface $bookRepository
     * @param \Pyz\Zed\Book\Persistence\BookEntityManagerInterface $bookEntityManager
     */
    public function __construct(
        BookRepositoryInterface $bookRepository,
        BookEntityManagerInterface $bookEntityManager
    ) {
        $this->bookRepository = $bookRepository;
        $this->bookEntityManager = $bookEntityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function createBook(PyzBookEntityTransfer $bookEntityTransfer): PyzBookEntityTransfer
    {
        return $this->bookEntityManager->saveBook($bookEntityTransfer);
    }

    /**
     * {@inheritdoc}
     */
    public function updateBook(PyzBookEntityTransfer $bookEntityTransfer): PyzBookEntityTransfer
    {
        return $this->bookEntityManager->saveBook($bookEntityTransfer);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteBook(int $idBook): void
    {
        $this->bookEntityManager->deleteBookById($idBook);
    }

    /**
     * {@inheritdoc}
     */
    public function findBookById(int $idBook): ?PyzBookEntityTransfer
    {
        return $this->bookRepository->findBookById($idBook);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllBooks(): array
    {
        return $this->bookRepository->findAllBooks();
    }


}
