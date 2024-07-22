<?php


/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence;

use Orm\Zed\Book\Persistence\PyzBookQuery;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface BookQueryContainerInterface extends QueryContainerInterface
{
    /**
     * Specification:
     * - Queries for a book by its name.
     *
     * @param string $name
     *
     * @return \Orm\Zed\Book\Persistence\PyzBookQuery
     * @api
     *
     */
    public function queryBookByName($name);

    /**
     * Specification:
     * - Queries for all books.
     *
     * @return \Orm\Zed\Book\Persistence\PyzBookQuery
     * @api
     *
     */
    public function queryBooks();

    /**
     * Specification:
     * - Queries for a book by its ID.
     *
     * @param int $idBook
     *
     * @return \Orm\Zed\Book\Persistence\PyzBookQuery
     * @api
     *
     */
    public function queryBookById($idBook);

    /**
     * Specification:
     * - Queries for books that match certain criteria.
     *
     * @param ModelCriteria $query
     *
     * @return ModelCriteria
     * @api
     *
     */
    public function queryDistinctBooksFromQuery(ModelCriteria $query);

    /**
     * Specification:
     * - Queries for books with missing descriptions.
     *
     * @return ModelCriteria
     * @api
     *
     */
    public function queryBooksWithMissingDescriptions();

    /**
     * Specification:
     * - Queries for books with missing publication dates.
     *
     * @return ModelCriteria
     * @api
     *
     */
    public function queryBooksWithMissingPublicationDates();

    /**
     * Specification:
     * - Queries for books by a list of IDs.
     *
     * @param array $idBooks
     *
     * @return \Orm\Zed\Book\Persistence\SpyBookQuery
     * @api
     *
     */
    public function queryBooksById(array $idBooks);
}
