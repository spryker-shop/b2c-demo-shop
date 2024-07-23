<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence;

use Generated\Shared\Transfer\PyzBookEntityTransfer;

interface BookRepositoryInterface
{
    /**
     * @param int $idBook
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer|null
     */
    public function findBookById(int $idBook): ?PyzBookEntityTransfer;

    /**
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer|null
     */
    public function findBookByName(string $name): ?PyzBookEntityTransfer;

    /**
     * @param array<int> $idBooks
     *
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    public function findBooksByIds(array $idBooks): array;

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     *
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    public function findBooksByPublicationDateRange(\DateTime $startDate, \DateTime $endDate): array;

    /**
     * @param string $description
     *
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    public function findBooksByDescription(string $description): array;

    /**
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    public function findAllBooks(): array;
}
