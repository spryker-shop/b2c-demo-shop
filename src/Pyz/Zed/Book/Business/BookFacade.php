<?php

namespace Pyz\Zed\Book\Business;

use Generated\Shared\Transfer\PyzBookTransfer;
use Orm\Zed\Book\Persistence\PyzBookQuery;
use Spryker\Zed\Kernel\Business\AbstractFacade;


class BookFacade extends AbstractFacade implements BookFacadeInterface
{
    public function createBook(PyzBookTransfer $bookTransfer)
    {
        $bookEntity = $this->getFactory()->createBookEntity();
        $bookEntity->fromArray($bookTransfer->toArray());
        $bookEntity->save();
    }

    public function updateBook(PyzBookTransfer $bookTransfer)
    {
        $bookEntity = PyzBookQuery::create()->findPk($bookTransfer->getIdPyzBook());
        if ($bookEntity) {
            $bookEntity->fromArray($bookTransfer->toArray());
            $bookEntity->save();
        }
    }

    public function deleteBook($id)
    {
        $bookEntity = PyzBookQuery::create()->findPk($id);
        if ($bookEntity) {
            $bookEntity->delete();
        }
    }
}
