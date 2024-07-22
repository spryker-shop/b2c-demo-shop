<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence\Mapper;

use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Generated\Shared\Transfer\PyzBookCollectionTransfer;
use Orm\Zed\Book\Persistence\PyzBook;
use Propel\Runtime\Collection\Collection;

class BookMapper implements BookMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $pyzBookEntityTransfer
     * @param \Orm\Zed\Book\Persistence\PyzBook $pyzBook
     *
     * @return \Orm\Zed\Book\Persistence\PyzBook
     */
    public function mapBookTransferToEntity(
        PyzBookEntityTransfer $pyzBookEntityTransfer,
        PyzBook $pyzBook
    ): PyzBook {
        $pyzBook->fromArray(
            $pyzBookEntityTransfer->modifiedToArray(false),
        );

        return $pyzBook;
    }

    /**
     * @param \Orm\Zed\Book\Persistence\PyzBook $pyzBook
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $pyzBookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function mapEntityToBookTransfer(
        PyzBook $pyzBook,
        PyzBookEntityTransfer $pyzBookEntityTransfer
    ): PyzBookEntityTransfer {
        return $pyzBookEntityTransfer->fromArray(
            $pyzBook->toArray(),
            true,
        );
    }

    /**
     * @param \Propel\Runtime\Collection\Collection<\Orm\Zed\Book\Persistence\PyzBook> $bookEntities
     *
     * @return \Generated\Shared\Transfer\PyzBookCollectionTransfer
     */
    public function mapBookEntityCollectionToBookCollectionTransfer(
        Collection $bookEntities
    ): PyzBookCollectionTransfer {
        $pyzBookCollectionTransfer = new PyzBookCollectionTransfer();

        foreach ($bookEntities as $bookEntity) {
            $pyzBookEntityTransfer = $this->mapEntityToBookTransfer(
                $bookEntity,
                new PyzBookEntityTransfer(),
            );

            $pyzBookCollectionTransfer->addBook($pyzBookEntityTransfer);
        }

        return $pyzBookCollectionTransfer;
    }
}
