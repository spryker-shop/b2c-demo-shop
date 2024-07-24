<?php


/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Communication\Controller;

use Orm\Zed\Book\Persistence\Map\PyzBookTableMap;
use Propel\Runtime\Map\TableMap;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Book\Communication\BookCommunicationFactory getFactory()
 * @method \Pyz\Zed\Book\Business\BookFacadeInterface getFacade()
 * @method \Pyz\Zed\Book\Persistence\BookQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class KeyController extends AbstractController
{
    /**
     * @var string
     */
    public const TERM = 'term';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function ajaxAction(Request $request)
    {
        $term = $request->get(static::TERM);

        $book = $this->getQueryContainer()
            ->queryBookByName($term)
            ->findOne();

        $idBook = false;
        if ($book) {
            $idBook = $book->getId();
        }

        $result = [];
        if ($idBook) {
            $bookData = $book->toArray(TableMap::TYPE_COLNAME);
            $result = [
                'id' => $bookData[PyzBookTableMap::COL_ID],
                'name' => $bookData[PyzBookTableMap::COL_NAME],
                'description' => $bookData[PyzBookTableMap::COL_DESCRIPTION],
                'publication_date' => $bookData[PyzBookTableMap::COL_PUBLICATION_DATE],
            ];
        }

        return $this->jsonResponse($result);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function suggestAction(Request $request)
    {
        $term = $request->get(static::TERM);

        /** @var \Propel\Runtime\Collection\ObjectCollection $books */
        $books = $this->getQueryContainer()
            ->queryBooksByName($term)
            ->find();

        $result = [];
        if ($books->count()) {
            $books = $books->toArray(null, false, TableMap::TYPE_COLNAME);

            foreach ($books as $value) {
                $result[] = $value[PyzBookTableMap::COL_NAME];
            }
        }

        return $this->jsonResponse($result);
    }
}
