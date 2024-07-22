<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence\Mapper;

use Generated\Shared\Transfer\PyzBookCollectionTransfer;
use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Orm\Zed\Book\Persistence\PyzBook;
use Propel\Runtime\Collection\Collection;

interface BookMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     * @param \Orm\Zed\Book\Persistence\PyzBook $bookEntity
     *
     * @return \Orm\Zed\Book\Persistence\PyzBook
     */
    public function mapBookTransferToEntity(
        PyzBookEntityTransfer $bookEntityTransfer,
        PyzBook $bookEntity
    ): PyzBook;

    /**
     * @param \Orm\Zed\Book\Persistence\PyzBook $bookEntity
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function mapEntityToBookTransfer(
        PyzBook $bookEntity,
        PyzBookEntityTransfer $bookEntityTransfer
    ): PyzBookEntityTransfer;

    /**
     * @param \Propel\Runtime\Collection\Collection $bookEntities
     *
     * @return \Generated\Shared\Transfer\PyzBookCollectionTransfer
     */
    public function mapBookEntityCollectionToBookCollectionTransfer(
        Collection $bookEntities
    ): PyzBookCollectionTransfer;
}
