<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Business\Writer;

use Generated\Shared\Transfer\BookResponseTransfer;
use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Pyz\Zed\Book\Persistence\BookEntityManagerInterface;

class BookWriter implements BookWriterInterface
{
    /**
     * @var \Pyz\Zed\Book\Persistence\BookEntityManagerInterface
     */
    protected $bookEntityManager;

    /**
     * @param \Pyz\Zed\Book\Persistence\BookEntityManagerInterface $bookEntityManager
     */
    public function __construct(BookEntityManagerInterface $bookEntityManager)
    {
        $this->bookEntityManager = $bookEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\BookResponseTransfer
     */
    public function createBook(PyzBookEntityTransfer $bookEntityTransfer): BookResponseTransfer
    {
        $bookResponseTransfer = new BookResponseTransfer();

        $savedBookEntityTransfer = $this->bookEntityManager->saveBook($bookEntityTransfer);
        if (!$savedBookEntityTransfer) {
            return $bookResponseTransfer->setIsSuccessful(false);
        }

        return $bookResponseTransfer
            ->setIsSuccessful(true)
            ->setBookEntityTransfer($savedBookEntityTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\BookResponseTransfer
     */
    public function updateBook(PyzBookEntityTransfer $bookEntityTransfer): BookResponseTransfer
    {
        $bookResponseTransfer = new BookResponseTransfer();

        $updatedBookEntityTransfer = $this->bookEntityManager->saveBook($bookEntityTransfer);
        if (!$updatedBookEntityTransfer) {
            return $bookResponseTransfer->setIsSuccessful(false);
        }

        return $bookResponseTransfer
            ->setIsSuccessful(true)
            ->setBookEntityTransfer($updatedBookEntityTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\BookResponseTransfer
     */
    public function deleteBook(PyzBookEntityTransfer $bookEntityTransfer): BookResponseTransfer
    {
        $bookResponseTransfer = new BookResponseTransfer();

        $isDeleted = $this->bookEntityManager->deleteBookById($bookEntityTransfer->getId());
        if (!$isDeleted) {
            return $bookResponseTransfer->setIsSuccessful(false);
        }

        return $bookResponseTransfer->setIsSuccessful(true);
    }
}
