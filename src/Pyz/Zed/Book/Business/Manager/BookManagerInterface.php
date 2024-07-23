<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Business\Manager;

use Generated\Shared\Transfer\PyzBookEntityTransfer;

interface BookManagerInterface
{
    /**
     * Specification:
     * - Creates a new book entity.
     * - Returns the created PyzBookEntityTransfer.
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function createBook(PyzBookEntityTransfer $bookEntityTransfer): PyzBookEntityTransfer;

    /**
     * Specification:
     * - Updates an existing book entity.
     * - Returns the updated PyzBookEntityTransfer.
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function updateBook(PyzBookEntityTransfer $bookEntityTransfer): PyzBookEntityTransfer;

    /**
     * Specification:
     * - Deletes an existing book entity by its ID.
     *
     * @param int $idBook
     *
     * @return void
     */
    public function deleteBook(int $idBook): void;

    /**
     * Specification:
     * - Finds a book by its ID.
     * - Returns the PyzBookEntityTransfer if found, null otherwise.
     *
     * @param int $idBook
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer|null
     */
    public function findBookById(int $idBook): ?PyzBookEntityTransfer;

    /**
     * Specification:
     * - Finds all books.
     * - Returns an array of PyzBookEntityTransfer.
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer[]
     */
    public function findAllBooks(): array;
}
