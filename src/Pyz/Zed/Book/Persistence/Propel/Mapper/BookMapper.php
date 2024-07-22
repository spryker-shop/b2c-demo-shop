<?php


/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Orm\Zed\Book\Persistence\PyzBook;

class BookMapper
{
    /**
     * @param \Orm\Zed\Book\Persistence\PyzBook $bookEntity
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $pyzBookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function mapBookEntityToPyzBookEntityTransfer(
        PyzBook      $bookEntity,
        PyzBookEntityTransfer $pyzBookEntityTransfer
    ): PyzBookEntityTransfer
    {
        return $pyzBookEntityTransfer->fromArray($bookEntity->toArray(), true);
    }
}
