<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Communication\Controller;

use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Book\Communication\BookCommunicationFactory getFactory()
 * @method \Pyz\Zed\Book\Business\BookFacadeInterface getFacade()
 * @method \Pyz\Zed\Book\Persistence\BookQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class EditController extends AbstractController
{
    /**
     * @var string
     */
    public const URL_PARAMETER_ID_BOOK = 'id-book';

    /**
     * @var string
     */
    public const MESSAGE_UPDATE_SUCCESS = 'Book %d was updated successfully.';

    /**
     * @var string
     */
    public const MESSAGE_UPDATE_ERROR = 'Book entry was not updated.';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request)
    {
        $idBook = $this->castId($request->query->get(static::URL_PARAMETER_ID_BOOK));

        $formData = $this
            ->getFactory()
            ->createBookDataProvider()
            ->getData($idBook);

        if ($formData === []) {
            $this->addErrorMessage("Book with id %s doesn't exist", ['%s' => $idBook]);

            return $this->redirectResponse($this->getFactory()->getConfig()->getDefaultRedirectUrl());
        }

        $bookForm = $this
            ->getFactory()
            ->getBookUpdateForm($formData);

        $bookForm->handleRequest($request);

        if ($bookForm->isSubmitted() && $bookForm->isValid()) {
            $data = $bookForm->getData();

            $pyzBookEntityTransfer = new PyzBookEntityTransfer();
            $pyzBookEntityTransfer->fromArray($data, true);

            $bookFacade = $this->getFacade();

            if ($bookFacade->saveBook($pyzBookEntityTransfer)) {
                $this->addSuccessMessage(static::MESSAGE_UPDATE_SUCCESS, ['%d' => $idBook]);

                return $this->redirectResponse('/book');
            }

            $this->addErrorMessage(static::MESSAGE_UPDATE_ERROR);

            return $this->redirectResponse('/book');
        }

        return $this->viewResponse([
            'form' => $bookForm->createView(),
            'id' => $idBook,
        ]);
    }
}
