<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Business\Reader;

use Generated\Shared\Transfer\BookResponseTransfer;
use Generated\Shared\Transfer\PyzBookEntityTransfer;

interface BookReaderInterface
{
    /**
     * Specification:
     * - Finds a book by its UUID.
     * - Returns a BookResponseTransfer containing book details and status.
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\BookResponseTransfer
     */
    public function findBookById(PyzBookEntityTransfer $bookEntityTransfer): BookResponseTransfer;
}
