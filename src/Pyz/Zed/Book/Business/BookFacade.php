<?php

namespace Pyz\Zed\Book\Business;

use Generated\Shared\Transfer\PyzBookTransfer;
use Orm\Zed\Customer\Persistence\SpyBookQuery;
use Propel\Runtime\Exception\PropelException;
use Spryker\Zed\Kernel\Business\AbstractFacade;


class BookFacade extends AbstractFacade implements BookFacadeInterface
{
    public function createBook(PyzBookTransfer $bookTransfer): void
    {
        $bookEntity = $this->getFactory()->createBookEntity();
        $bookEntity->fromArray($bookTransfer->toArray());
        $bookEntity->save();
    }

    /**
     * @throws PropelException
     */
    public function updateBook(PyzBookTransfer $bookTransfer): void
    {
        $bookEntity = SpyBookQuery::create()->findPk($bookTransfer->getIdBook());
        if ($bookEntity) {
            $bookEntity->fromArray($bookTransfer->toArray());
            $bookEntity->save();
        }
    }

    /**
     * @throws PropelException
     */
    public function deleteBook($id): void
    {
        $bookEntity = SpyBookQuery::create()->findPk($id);
        if ($bookEntity) {
            $bookEntity->delete();
        }
    }
}
