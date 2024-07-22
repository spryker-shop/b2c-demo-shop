<?php
namespace Pyz\Zed\Book\Communication\Controller;

use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Pyz\Zed\Book\Business\BookFacadeInterface;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Book\Communication\BookCommunicationFactory getFactory()
 * @method \Pyz\Zed\Book\Business\BookFacadeInterface getFacade()
 */
class AddController extends AbstractController
{
    /**
     * @var string
     */
    public const MESSAGE_CREATE_SUCCESS = 'Book %d was created successfully.';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request)
    {
        $bookForm = $this
            ->getFactory()
            ->getBookCreateForm();

        $bookForm->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $data = $bookForm->getData();

            $bookTransfer = new PyzBookEntityTransfer();
            $bookTransfer->fromArray($data, true);

            $bookFacade = $this->getFacade();
            $bookFacade->createBook($bookTransfer);
            $idBook = $bookTransfer->getIdBook();

            $this->addSuccessMessage(static::MESSAGE_CREATE_SUCCESS, ['%d' => $idBook]);

            return $this->redirectResponse('/book/list');
        }

        return $this->viewResponse([
            'form' => $bookForm->createView(),
        ]);
    }
}
