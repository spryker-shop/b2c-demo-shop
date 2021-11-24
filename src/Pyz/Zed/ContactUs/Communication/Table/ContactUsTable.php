<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Communication\Table;

use Orm\Zed\ContactUs\Persistence\Map\PyzContactUsTableMap;
use Orm\Zed\ContactUs\Persistence\PyzContactUs;
use Propel\Runtime\Collection\ObjectCollection;
use Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class ContactUsTable extends AbstractTable
{
    public const COL_ID_ANTELOPE = 'id_contact_us';
    public const COL_FULL_NAME = 'full_name';
    public const COL_EMAIL = 'email';
    public const COL_MESSAGE = 'message';

    /**
     * @var \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface
     */
    protected $contactUsQueryContainer;

    /**
     * @param \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface $contactUsQueryContainer
     */
    public function __construct(ContactUsQueryContainerInterface $contactUsQueryContainer)
    {
        $this->contactUsQueryContainer = $contactUsQueryContainer;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config)
    {
        $config->setHeader(
            [
                static::COL_ID_ANTELOPE => '#',
                static::COL_FULL_NAME => 'Full name',
                static::COL_EMAIL => 'Email',
                static::COL_MESSAGE => 'Message',
            ]
        );

        $config->setSortable(
            [
                static::COL_ID_ANTELOPE,
                static::COL_FULL_NAME,
                static::COL_EMAIL,
                static::COL_MESSAGE,
            ]
        );

        $config->setSearchable(
            [
                PyzContactUsTableMap::COL_FULL_NAME,
                PyzContactUsTableMap::COL_EMAIL,
                PyzContactUsTableMap::COL_MESSAGE,
            ]
        );

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $query = $this->prepareQuery();

        /** @var \Propel\Runtime\Collection\ObjectCollection|\Orm\Zed\ContactUs\Persistence\PyzContactUs[] $contactUsCollection */
        $contactUsCollection = $this->runQuery($query, $config, true);

        if ($contactUsCollection->count() < 1) {
            return [];
        }

        return $this->mapContactUsCollection($contactUsCollection);
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection|\Orm\Zed\ContactUs\Persistence\PyzContactUs[] $contactUsCollection
     *
     * @return array
     */
    protected function mapContactUsCollection(ObjectCollection $contactUsCollection)
    {
        $contactUsList = [];

        foreach ($contactUsCollection as $contactUsEntity) {
            $contactUsList[] = $this->mapContactUsRow($contactUsEntity);
        }

        return $contactUsList;
    }

    /**
     * @param \Orm\Zed\ContactUs\Persistence\PyzContactUs $contactUsEntity
     *
     * @return array
     */
    protected function mapContactUsRow(PyzContactUs $contactUsEntity)
    {
        $contactUsRow = $contactUsEntity->toArray();

        $contactUsRow[static::COL_ID_ANTELOPE] = $contactUsEntity->getIdContactUs();
        $contactUsRow[static::COL_FULL_NAME] = $contactUsEntity->getFullName();
        $contactUsRow[static::COL_EMAIL] = $contactUsEntity->getEmail();
        $contactUsRow[static::COL_MESSAGE] = $contactUsEntity->getMessage();

        return $contactUsRow;
    }

    /**
     * @return \Orm\Zed\ContactUs\Persistence\PyzContactUsQuery
     */
    protected function prepareQuery()
    {
        $query = $this->contactUsQueryContainer->queryContactUs();

        return $query;
    }
}
