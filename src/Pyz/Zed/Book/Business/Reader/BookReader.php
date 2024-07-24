<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Business\Reader;

use Generated\Shared\Transfer\BookResponseTransfer;
use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Pyz\Zed\Book\Persistence\BookRepositoryInterface;

class BookReader implements BookWtriterInterface
{
    /**
     * @var \Pyz\Zed\Book\Persistence\BookRepositoryInterface
     */
    protected $bookRepository;

    /**
     * @param \Pyz\Zed\Book\Persistence\BookRepositoryInterface $bookRepository
     */
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\BookResponseTransfer
     */
    public function findBookById(PyzBookEntityTransfer $bookEntityTransfer): BookResponseTransfer
    {
        $bookEntityTransfer->requireId();

        $bookEntity = $this->bookRepository->findBookById(
            $bookEntityTransfer->getId()
        );

        $bookResponseTransfer = new BookResponseTransfer();
        if (!$bookEntity) {
            return $bookResponseTransfer->setIsSuccessful(false);
        }

        // Assuming BookResponseTransfer should use a BookTransfer object
        $bookResponseTransfer
            ->setIsSuccessful(true)
            ->setBookTransfer($bookEntityTransfer->fromArray($bookEntity->toArray()));

        return $bookResponseTransfer;
    }
}
