<?php

namespace Pyz\Zed\Book\Communication\Controller;

use Generated\Shared\Transfer\PyzBookTransfer;
use Orm\Zed\Book\Persistence\PyzBookQuery;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class BookController extends AbstractController
{
    public function indexAction()
    {
        $books = PyzBookQuery::create()->find();
        return $this->viewResponse(['books' => $books]);
    }

    public function createAction(Request $request)
    {
        $bookTransfer = new PyzBookTransfer();
        $form = $this->getFactory()->createBookForm($bookTransfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getFacade()->createBook($bookTransfer);
            return $this->redirectResponse('/book');
        }

        return $this->viewResponse(['form' => $form->createView()]);
    }

    public function updateAction(Request $request, $id)
    {
        $bookEntity = PyzBookQuery::create()->findPk($id);
        if (!$bookEntity) {
            return $this->redirectResponse('/book');
        }

        $bookTransfer = new PyzBookTransfer();
        $bookTransfer->fromArray($bookEntity->toArray(), true);

        $form = $this->getFactory()->createBookForm($bookTransfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getFacade()->updateBook($bookTransfer);
            return $this->redirectResponse('/book');
        }

        return $this->viewResponse(['form' => $form->createView()]);
    }

    public function deleteAction($id)
    {
        $this->getFacade()->deleteBook($id);
        return $this->redirectResponse('/book');
    }
}
