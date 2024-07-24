<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence;

use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\Book\Persistence\BookPersistenceFactory getFactory()
 */
class BookRepository extends AbstractRepository implements BookRepositoryInterface
{
    /**
     * @param int $idBook
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer|null
     */
    public function findBookById(int $idBook): ?PyzBookEntityTransfer
    {
        /** @var \Orm\Zed\Book\Persistence\PyzBook $bookEntity */
        $bookEntity = $this->getFactory()->createBookQuery()
            ->filterById($idBook)
            ->findOne();

        if (!$bookEntity) {
            return null;
        }

        return $this->getFactory()->createBookMapper()->mapEntityToBookTransfer($bookEntity, new PyzBookEntityTransfer());
    }

    /**
     * @param string $name
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer|null
     */
    public function findBookByName(string $name): ?PyzBookEntityTransfer
    {
        /** @var \Orm\Zed\Book\Persistence\PyzBook $bookEntity */
        $bookEntity = $this->getFactory()->createBookQuery()
            ->filterByName($name)
            ->findOne();

        if (!$bookEntity) {
            return null;
        }

        return $this->getFactory()->createBookMapper()->mapEntityToBookTransfer($bookEntity, new PyzBookEntityTransfer());
    }

    /**
     * @param array<int> $idBooks
     *
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    public function findBooksByIds(array $idBooks): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\Book\Persistence\PyzBook> $bookEntities */
        $bookEntities = $this->getFactory()->createBookQuery()
            ->filterByIdBook_In($idBooks)
            ->find();

        if ($bookEntities->isEmpty()) {
            return [];
        }

        return $this->mapBookEntitiesToPyzBookEntityTransfers($bookEntities);
    }

    /**
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     *
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    public function findBooksByPublicationDateRange(\DateTime $startDate, \DateTime $endDate): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\Book\Persistence\PyzBook> $bookEntities */
        $bookEntities = $this->getFactory()->createBookQuery()
            ->filterByPublicationDate(['min' => $startDate, 'max' => $endDate])
            ->find();

        if ($bookEntities->isEmpty()) {
            return [];
        }

        return $this->mapBookEntitiesToPyzBookEntityTransfers($bookEntities);
    }

    /**
     * @param string $description
     *
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    public function findBooksByDescription(string $description): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\Book\Persistence\PyzBook> $bookEntities */
        $bookEntities = $this->getFactory()->createBookQuery()
            ->filterByDescription('%' . $description . '%', \Criteria::LIKE)
            ->find();

        if ($bookEntities->isEmpty()) {
            return [];
        }

        return $this->mapBookEntitiesToPyzBookEntityTransfers($bookEntities);
    }

    /**
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    public function findAllBooks(): array
    {
        /** @var \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\Book\Persistence\PyzBook> $bookEntities */
        $bookEntities = $this->getFactory()->createBookQuery()->find();

        if ($bookEntities->isEmpty()) {
            return [];
        }

        return $this->mapBookEntitiesToPyzBookEntityTransfers($bookEntities);
    }

    /**
     * @param \Orm\Zed\Book\Persistence\PyzBook $bookEntity
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    protected function mapBookEntityToPyzBookEntityTransfer(\Orm\Zed\Book\Persistence\PyzBook $bookEntity): PyzBookEntityTransfer
    {
        return $this->getFactory()->createBookMapper()->mapEntityToBookTransfer($bookEntity, new PyzBookEntityTransfer());
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\Book\Persistence\PyzBook> $bookEntities
     *
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    protected function mapBookEntitiesToPyzBookEntityTransfers(ObjectCollection $bookEntities): array
    {
        $pyzBookEntityTransfers = [];
        foreach ($bookEntities as $bookEntity) {
            $pyzBookEntityTransfers[] = $this->mapBookEntityToPyzBookEntityTransfer($bookEntity);
        }

        return $pyzBookEntityTransfers;
    }
}
