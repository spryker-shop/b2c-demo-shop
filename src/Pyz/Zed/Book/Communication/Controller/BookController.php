<?php
namespace Pyz\Zed\Book\Communication\Controller;

use Generated\Shared\Transfer\DateTimeTransfer;
use Generated\Shared\Transfer\BookTransfer;
use Orm\Zed\Book\Persistence\PyzBook;
use Pyz\Zed\Book\Communication\BookCommunicationFactory;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    
    public function createAction(Request $request)
    {
        $bookTransfer = new BookTransfer();

        // Set default values
        $dateTimeTransfer = new DateTimeTransfer();
        $dateTimeTransfer->fromDateTime(new \DateTime());
        $bookTransfer->setPublicationDate($dateTimeTransfer);

        // Create the form and handle the request
        $bookForm = $this->getFactory()->createBookForm()->setData($bookTransfer)->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $bookTransferData = $bookForm->getData();

            $this->getFacade()->createBook($bookTransferData);

            $this->addSuccessMessage('Book added.');

            return $this->redirectResponse('/book');
        }

        return $this->viewResponse([
            'bookForm' => $bookForm->createView(),
        ]);
    }

    // Convert pyz object to transfer object
    protected function convertEntityToTransfer(PyzBook $bookEntity): BookTransfer
    {
        $bookTransfer = new BookTransfer();
        $bookTransfer->setIdBook($bookEntity->getIdBook());
        $bookTransfer->setName($bookEntity->getName());
        $bookTransfer->setDescription($bookEntity->getDescription());

        $dateTimeTransfer = new DateTimeTransfer();
        $dateTimeTransfer->fromDateTime($bookEntity->getPublicationDate());
        $bookTransfer->setPublicationDate($dateTimeTransfer);

        return $bookTransfer;
    }


    // Convert transfer object to pyz object
    private function convertTransferToPyz($bookTransfer)
    {
        $bookEntity = new PyzBook();
        $bookEntity->fromArray($bookTransfer->toArray());
        return $bookEntity;
    }

    // For editing a book record
    public function editAction(Request $request)
    {
        $idBook = $this->castId($request->get('id'));
        
        // Retrieve the existing book data
        $pyzBook = $this->getFacade()->findBookById($idBook);

        if (!$pyzBook) {
            $this->addErrorMessage('Book not found.');
            return $this->redirectResponse('/book');
        }

        // Convert PyzBook entity to BookTransfer
        $bookTransfer = $this->convertEntityToTransfer($pyzBook);

        // Ensure the existing publication date is set properly in the form
        $dateTimeTransfer = $bookTransfer->getPublicationDate();
        if (!$dateTimeTransfer) {
            $dateTimeTransfer = new DateTimeTransfer();
            $dateTimeTransfer->fromDateTime(new \DateTime());
            $bookTransfer->setPublicationDate($dateTimeTransfer);
        }

        // Create the form and handle the request
        $bookForm = $this->getFactory()->editBookForm()->setData($bookTransfer)->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $bookTransferData = $bookForm->getData();

            $this->getFacade()->updateBook($idBook, $bookTransferData);

            $this->addSuccessMessage('Book updated successfully.');

            return $this->redirectResponse('/book');
        }

        return $this->viewResponse([
            'bookForm' => $bookForm->createView(),
            'idBook' => $idBook,
        ]);
    }

    // For deleting a book record.
    public function deleteAction(Request $request)
    {
        $idBook = $this->castId($request->get('id'));

        $this->getFacade()->deleteBook($idBook);
        $this->addSuccessMessage('Book deleted.');

        return $this->redirectResponse('/book');
    }
}
