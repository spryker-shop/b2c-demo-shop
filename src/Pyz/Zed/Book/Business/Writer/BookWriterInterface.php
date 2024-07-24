<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Business\Writer;

use Generated\Shared\Transfer\BookResponseTransfer;
use Generated\Shared\Transfer\PyzBookEntityTransfer;

interface BookWriterInterface
{
    /**
     * Specification:
     * - Creates a new book entity.
     * - Returns a BookResponseTransfer containing the created book details and status.
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\BookResponseTransfer
     */
    public function createBook(PyzBookEntityTransfer $bookEntityTransfer): BookResponseTransfer;

    /**
     * Specification:
     * - Updates an existing book entity.
     * - Returns a BookResponseTransfer containing the updated book details and status.
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\BookResponseTransfer
     */
    public function updateBook(PyzBookEntityTransfer $bookEntityTransfer): BookResponseTransfer;

    /**
     * Specification:
     * - Deletes an existing book entity.
     * - Returns a BookResponseTransfer indicating the deletion status.
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\BookResponseTransfer
     */
    public function deleteBook(PyzBookEntityTransfer $bookEntityTransfer): BookResponseTransfer;
}
