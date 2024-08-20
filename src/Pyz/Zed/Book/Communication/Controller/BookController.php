<?php

namespace Pyz\Zed\Book\Communication\Controller;

use Pyz\Zed\Book\BookTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Pyz\Zed\Book\Communication\BookCommunicationFactory;

/**
 * @method \Pyz\Zed\Book\Business\BookFacade getFacade()
 */
class BookController extends AbstractController
{
    public function indexAction()
    {
        $bookCollection = $this->getFacade()->findAllBooks();
        return $this->viewResponse(['books' => $bookCollection]);
    }
    
    public function createAction(Request $request)
    {
        $bookTransfer = new BookTransfer();
        $form = $this->getFactory()->createBookForm($bookTransfer)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$bookTransfer->getName() || !$bookTransfer->getDescription() || !$bookTransfer->getPublicationDate()) {
                $this->addErrorMessage('Name, Description, and Publication Date are required.');
                return $this->viewResponse(['form' => $form->createView()]);
            }

            $this->getFacade()->createBook($bookTransfer);
            $this->addSuccessMessage('Book successfully created.');
            return $this->redirectResponse('/book/book');
        }

        return $this->viewResponse(['form' => $form->createView()]);
    }

    // public function editAction(Request $request)
    // {
    //     $id = $request->query->get('id');

    //     $bookTransfer = $this->getFacade()->findBookById($id);
    //     if (!$bookTransfer) {
    //         $this->addErrorMessage('Book not found.');
    //         return $this->redirectResponse('/book/book');
    //     }

    //     $form = $this->getFactory()->createBookForm($bookTransfer)->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getFacade()->updateBook($bookTransfer);
    //         $this->addSuccessMessage('Book successfully updated.');
    //         return $this->redirectResponse('/book/book/update?id='.$id);
    //     }

    //     return $this->viewResponse(['form' => $form->createView()]);
    public function editAction(Request $request)
    {
        $id = $request->query->get('id');
    
        $bookEntity = $this->getFacade()->findBookById($id);
        if (!$bookEntity) {
            $this->addErrorMessage('Book not found.');
            return $this->redirectResponse('/book/book');
        }    
        $bookTransfer = $this->getFactory()->createBookMapper()->mapEntityToTransfer($bookEntity);
    
    
        $form = $this->getFactory()->createBookForm($bookTransfer)->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getFacade()->updateBook($bookTransfer);
            $this->addSuccessMessage('Book successfully updated.');
            return $this->redirectResponse('/book/book');
        }
    
        return $this->viewResponse(['form' => $form->createView()]);
    }
    
    
    
    

    public function deleteAction(Request $request)
    {
        $id = $request->query->get('id');
        $this->getFacade()->deleteBook($id);
        $this->addSuccessMessage('Book successfully deleted.');
        return $this->redirectResponse('/book/book');
    }
}
