<?php

namespace Pyz\Zed\Book\Communication\Controller;

use Generated\Shared\Transfer\PyzBookTransfer;
use Orm\Zed\Customer\Persistence\SpyBookQuery;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    public function indexAction(): array
    {
        $books = SpyBookQuery::create()->find();
        return $this->viewResponse(['books' => $books]);
    }

    public function createAction(Request $request): array|RedirectResponse
    {
        $bookTransfer = new PyzBookTransfer();
        $form = $this->getFactory()->createBookForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getFacade()->createBook($bookTransfer);
            return $this->redirectResponse('/book');
        }

        return $this->viewResponse(['form' => $form->createView()]);
    }

    public function updateAction(Request $request, $id): array|RedirectResponse
    {
        $bookEntity = SpyBookQuery::create()->findPk($id);
        if (!$bookEntity) {
            return $this->redirectResponse('/book');
        }

        $bookTransfer = new PyzBookTransfer();
        $bookTransfer->fromArray($bookEntity->toArray(), true);
        $form = $this->getFactory()->createBookForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getFacade()->updateBook($bookTransfer);
            return $this->redirectResponse('/book');
        }

        return $this->viewResponse(['form' => $form->createView()]);
    }

    public function deleteAction($id): RedirectResponse
    {
        $this->getFacade()->deleteBook($id);
        return $this->redirectResponse('/book');
    }

}
