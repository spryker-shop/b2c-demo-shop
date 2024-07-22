<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Business;

use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\Book\Business\BookBusinessFactory getFactory()
 * @method \Pyz\Zed\Book\Persistence\BookQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class BookFacade extends AbstractFacade implements BookFacadeInterface
{
    /**
     * {@inheritdoc}
     */
    public function createBook(PyzBookEntityTransfer $pyzBookEntityTransfer): PyzBookEntityTransfer
    {
        return $this->getFactory()->createBookWriter()->createBook($pyzBookEntityTransfer);
    }

    /**
     * {@inheritdoc}
     */
    public function updateBook(PyzBookEntityTransfer $pyzBookEntityTransfer): PyzBookEntityTransfer
    {
        return $this->getFactory()->createBookWriter()->updateBook($pyzBookEntityTransfer);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteBook(int $idBook): void
    {
        $this->getFactory()->createBookWriter()->deleteBook($idBook);
    }

    /**
     * {@inheritdoc}
     */
    public function findBookById(int $idBook): ?PyzBookEntityTransfer
    {
        return $this->getRepository()->findBookById($idBook);
    }

    /**
     * {@inheritdoc}
     */
    public function findAllBooks(): array
    {
        return $this->getRepository()->findAllBooks();
    }

    // Uncomment and implement if required
    // public function findBooksByCriteria(BookCriteriaTransfer $criteriaTransfer): array
    // {
    //     return $this->getRepository()->findBooksByCriteria($criteriaTransfer);
    // }
}
