<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Persistence;

use Orm\Zed\Book\Persistence\Map\PyzBookTableMap;
use Orm\Zed\Book\Persistence\PyzBookQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \Pyz\Zed\Book\Persistence\BookPersistenceFactory getFactory()
 */
class BookQueryContainer extends AbstractQueryContainer implements BookQueryContainerInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $name
     *
     * @return \Orm\Zed\Book\Persistence\PyzBookQuery
     */
    public function queryBookByName($name)
    {
        $query = $this->queryBooks();
        $query->filterByName($name);

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Orm\Zed\Book\Persistence\PyzBookQuery
     */
    public function queryBooks()
    {
        return $this->getFactory()->createBookQuery();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idBook
     *
     * @return \Orm\Zed\Book\Persistence\PyzBookQuery
     */
    public function queryBookById($idBook)
    {
        $query = $this->queryBooks();
        $query->filterById($idBook);

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function queryDistinctBooksFromQuery(ModelCriteria $query)
    {
        $query
            ->distinct()
            ->withColumn(PyzBookTableMap::COL_ID, 'value')
            ->withColumn(PyzBookTableMap::COL_NAME, 'label');

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function queryBooksWithMissingDescriptions()
    {
        $query = $this->queryBooks();
        $query->where(PyzBookTableMap::COL_DESCRIPTION . ' IS NULL');

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function queryBooksWithMissingPublicationDates()
    {
        $query = $this->queryBooks();
        $query->where(PyzBookTableMap::COL_PUBLICATION_DATE . ' IS NULL');

        return $query;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $idBooks
     *
     * @return \Orm\Zed\Book\Persistence\PyzBookQuery
     */
    public function queryBooksById(array $idBooks)
    {
        $query = $this->queryBooks();
        $query->filterById($idBooks, Criteria::IN);

        return $query;
    }
}
