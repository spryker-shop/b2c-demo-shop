<?php

namespace Pyz\Zed\Faq\Communication\Table;

use Orm\Zed\Planet\Persistence\Map\PyzFaqTableMap;
use Orm\Zed\Planet\Persistence\Map\PyzPlanetTableMap;
use Orm\Zed\Planet\Persistence\PyzFaqQuery;
use Orm\Zed\Planet\Persistence\PyzMoonQuery;
use Orm\Zed\Planet\Persistence\PyzPlanetQuery;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class FaqTable extends AbstractTable {

    const COL_ACTIONS = 'Actions';

    /** @var PyzFaqQuery
     */
    private PyzFaqQuery $faqQuery;

    /**
     * @param PyzFaqQuery $faqQuery
     */
    public function __construct(PyzFaqQuery $faqQuery) {
        $this->faqQuery = $faqQuery;
    }

    /**
     * @param TableConfiguration $config
     *
     * @return TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration  {

        $config->setHeader([
            PyzFaqTableMap::COL_ID_FAQ => 'Faq ID',
            PyzFaqTableMap::COL_QUESTION=> 'Question',
            PyzFaqTableMap::COL_ANSWER => 'Answer',
            PyzFaqTableMap::COL_ENABLED => 'Enabled',
            static::COL_ACTIONS => static::COL_ACTIONS,
        ]);

        $config->setSortable([
            PyzFaqTableMap::COL_ID_FAQ,
            PyzFaqTableMap::COL_ENABLED,
        ]);

        $config->setSearchable([

        ]);

        $config->setRawColumns([
            PyzFaqTableMap::COL_ENABLED,
            static::COL_ACTIONS,
        ]);

        return $config;
    }

    /**
     * @param TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config) : array {

        $faqDataItems = $this->runQuery(
            $this->faqQuery,
            $config
        );

        $faqTableRows = [];

        foreach ($faqDataItems as $faqDataItem) {
            $planetTableRows[] = [
                PyzFaqTableMap::COL_ID_FAQ =>
                    $faqDataItem[PyzFaqTableMap::COL_ID_FAQ],
                PyzFaqTableMap::COL_QUESTION =>
                    $faqDataItem[PyzFaqTableMap::COL_QUESTION],
                PyzFaqTableMap::COL_ANSWER =>
                    $faqDataItem[PyzFaqTableMap::COL_ANSWER],
                PyzFaqTableMap::COL_ENABLED =>
                    $faqDataItem[PyzFaqTableMap::COL_ENABLED],
                static::COL_ACTIONS =>
                    $this->generateActions($faqDataItem[PyzFaqTableMap::COL_ID_FAQ]),
            ];
        }

        return $faqTableRows;
    }

    protected function generateActions(int $id): string {

        return implode(' ', [
            $this->createEditButton($id),
            $this->createDeleteButton($id),
        ]);
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function createEditButton(int $id): string {
        return $this->generateEditButton(
            Url::generate(
                '/faq/faq-edit', [
                'id-faq' => $id,
            ]),
            'Edit'
        );
    }

    /**
     * @param int $id
     *
     * @return string
     */
    protected function createDeleteButton(int $id): string {
        return $this->generateRemoveButton(
            Url::generate(
                '/faq/faq-delete', [
                'id-faq' => $id,
            ]),
            'Delete'
        );
    }
}
