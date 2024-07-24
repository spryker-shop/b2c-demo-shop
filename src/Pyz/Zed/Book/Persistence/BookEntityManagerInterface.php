<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence;

use Generated\Shared\Transfer\PyzBookEntityTransfer;

interface BookEntityManagerInterface
{
    /**
     * Specification:
     * - Creates a book
     * - Finds a book by PyzBookEntityTransfer::id in the transfer
     * - Updates fields in a book entity
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function saveBook(PyzBookEntityTransfer $bookEntityTransfer): PyzBookEntityTransfer;

    /**
     * Specification:
     * - Finds a book by id
     * - Deletes the book
     *
     * @param int $idBook
     *
     * @return void
     */
    public function deleteBookById(int $idBook): void;

    /**
     * Specification:
     * - Adds new relations between authors and book
     *
     * @param array $idAuthors
     * @param int $idBook
     *
     * @return void
     */
    public function addAuthors(array $idAuthors, int $idBook): void;

    /**
     * Specification:
     * - Remove relations between authors and book
     *
     * @param array $idAuthors
     * @param int $idBook
     *
     * @return void
     */
    public function removeAuthors(array $idAuthors, int $idBook): void;
}
