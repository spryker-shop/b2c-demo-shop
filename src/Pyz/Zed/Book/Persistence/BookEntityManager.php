<?php

/**
 * Copyright © [year]-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence;

use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Orm\Zed\Book\Persistence\PyzBook;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\Book\Persistence\BookPersistenceFactory getFactory()
 */
class BookEntityManager extends AbstractEntityManager implements BookEntityManagerInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $bookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function saveBook(PyzBookEntityTransfer $bookEntityTransfer): PyzBookEntityTransfer
    {
        $spyBook = $this->getFactory()
            ->createBookQuery()
            ->filterById($bookEntityTransfer->getId())
            ->findOneOrCreate();

        $spyBook = $this->getFactory()
            ->createBookMapper()
            ->mapBookTransferToEntity($bookEntityTransfer, $spyBook);

        $spyBook->save();

        $bookEntityTransfer->fromArray($spyBook->toArray(), true);

        return $bookEntityTransfer;
    }

    /**
     * {@inheritDoc}
     *
     * @param int $idBook
     *
     * @return void
     */
    public function deleteBookById(int $idBook): void
    {
        $this->getFactory()
            ->createBookQuery()
            ->filterById($idBook)
            ->delete();
    }

    /**
     * {@inheritDoc}
     *
     * @param array $idAuthors
     * @param int $idBook
     *
     * @return void
     */
    public function addAuthors(array $idAuthors, int $idBook): void
    {
        foreach ($idAuthors as $idAuthor) {
            $bookAuthorEntity = $this->getFactory()
                ->createBookAuthorQuery()
                ->filterByFkBook($idBook)
                ->filterByFkAuthor($idAuthor)
                ->findOneOrCreate();

            $bookAuthorEntity->save();
        }
    }

    /**
     * {@inheritDoc}
     *
     * @param array $idAuthors
     * @param int $idBook
     *
     * @return void
     */
    public function removeAuthors(array $idAuthors, int $idBook): void
    {
        if (count($idAuthors) === 0) {
            return;
        }

        $this->getFactory()
            ->createBookAuthorQuery()
            ->filterByFkBook($idBook)
            ->filterByFkAuthor_In($idAuthors)
            ->delete();
    }
}
