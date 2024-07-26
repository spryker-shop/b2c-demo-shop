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
 * @method \Pyz\Zed\Book\Business\BookFacade getFacade()
 * @method \Pyz\Zed\Book\Persistence\BookQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class DeleteController extends AbstractController
{
    /**
     * @var string
     */
    public const URL_PARAMETER_ID_BOOK = 'id-book';

    /**
     * @var string
     */
    public const MESSAGE_DELETE_SUCCESS = 'Book %d was deleted successfully.';

    /**
     * @var string
     */
    public const MESSAGE_DELETE_ERROR = 'Book entry was not deleted.';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $idBook = $this->castId($request->query->get(static::URL_PARAMETER_ID_BOOK));

        $formData = $this
            ->getFactory()
            ->createBookFormDataProvider()
            ->getData($idBook);

        if ($formData === []) {
            $this->addErrorMessage("Book with id %s doesn't exist", ['%s' => $idBook]);

            return $this->redirectResponse($this->getFactory()->getConfig()->getDefaultRedirectUrl());
        }

        $bookEntityTransfer = (new PyzBookEntityTransfer())->fromArray($formData, true);
        $bookEntityTransfer->setId($idBook);

        try {
            $this->getFacade()->deleteBook($bookEntityTransfer);
            $this->addSuccessMessage(static::MESSAGE_DELETE_SUCCESS, ['%d' => $idBook]);
        } catch (\Exception $e) {
            $this->addErrorMessage(static::MESSAGE_DELETE_ERROR);
        }

        return $this->redirectResponse('/book');
    }
}
