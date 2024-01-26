<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTaskGui\Communication\Table;

use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\CustomerTask\Persistence\Map\PyzCustomerTaskTableMap;
use Orm\Zed\CustomerTask\Persistence\Map\PyzCustomerTaskTagTableMap;
use Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class CustomerTaskTable extends AbstractTable
{
    /**
     * @var string
     */
    private const COL_ID = 'Id';

    /**
     * @var string
     */
    private const COL_TITLE = 'Title';

    /**
     * @var string
     */
    private const COL_DESCRIPTION = 'Description';

    /**
     * @var string
     */
    private const COL_TAGS = 'Tags';

    /**
     * @var string
     */
    private const COL_CREATOR = 'Creator';

    /**
     * @var string
     */
    private const COL_OWNER = 'Owner';

    /**
     * @var string
     */
    private const COL_DUE_DATE = 'Due Date';

    /**
     * @var string
     */
    private const COL_STATUS = 'Status';

    /**
     * @var string
     */
    private const CUSTOMER_OWNER_TABLE_ALIAS = 'customer_owner';

    /**
     * @var \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery
     */
    private PyzCustomerTaskQuery $customerTaskQuery;

    /**
     * @param \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery $customerTaskQuery
     */
    public function __construct(PyzCustomerTaskQuery $customerTaskQuery)
    {
        $this->customerTaskQuery = $customerTaskQuery;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $this->setHeaders($config);
        $this->setSortable($config);
        $this->setSearchable($config);
        $this->setRawColumns($config);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array<int, <string, string>>
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $data = $this->runQuery($this->prepareQuery(), $config);

        $result = [];
        foreach ($data as $row) {
            $row[PyzCustomerTaskTableMap::COL_FK_CREATOR] = $row[self::COL_CREATOR];
            $row[PyzCustomerTaskTableMap::COL_FK_OWNER] = $row[self::COL_OWNER];
            $row[self::COL_TAGS] = $this->prepareTags($row[self::COL_TAGS]);
            $result[] = $row;
        }

        return $result;
    }

    /**
     * @param string|null $tags
     *
     * @return string|null
     */
    private function prepareTags(?string $tags): ?string
    {
        if (!$tags) {
            return null;
        }
        $tags = explode(',', $tags);
        $result = '';
        foreach ($tags as $tag) {
            $result .= $this->generateLabel($tag, 'label-success');
        }

        return $result;
    }

    /**
     * @return \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery
     */
    private function prepareQuery(): PyzCustomerTaskQuery
    {
        $this->customerTaskQuery
            ->useCreatorQuery()
                ->withColumn(
                    sprintf('CONCAT(%s, " ", %s)', SpyCustomerTableMap::COL_FIRST_NAME, SpyCustomerTableMap::COL_LAST_NAME),
                    self::COL_CREATOR,
                )
            ->endUse()
            ->useOwnerQuery(self::CUSTOMER_OWNER_TABLE_ALIAS, Criteria::LEFT_JOIN)
                ->withColumn(
                    sprintf(
                        'CONCAT(%s, " ", %s)',
                        $this->applyAliasToQueryField(
                            SpyCustomerTableMap::COL_FIRST_NAME,
                            SpyCustomerTableMap::TABLE_NAME,
                            self::CUSTOMER_OWNER_TABLE_ALIAS,
                        ),
                        $this->applyAliasToQueryField(
                            SpyCustomerTableMap::COL_LAST_NAME,
                            SpyCustomerTableMap::TABLE_NAME,
                            self::CUSTOMER_OWNER_TABLE_ALIAS,
                        ),
                    ),
                    self::COL_OWNER,
                )
            ->endUse()
            ->usePyzCustomerTaskTagRelationQuery(null, Criteria::LEFT_JOIN)
                ->usePyzCustomerTaskTagQuery(null, Criteria::LEFT_JOIN)
                    ->withColumn(
                        sprintf('GROUP_CONCAT(DISTINCT %s)', PyzCustomerTaskTagTableMap::COL_TAG),
                        self::COL_TAGS,
                    )
                ->endUse()
            ->endUse()
            ->groupByIdCustomerTask();

        return $this->customerTaskQuery;
    }

    /**
     * @param string $field
     * @param string $tableName
     * @param string $aliasName
     *
     * @return string
     */
    private function applyAliasToQueryField(string $field, string $tableName, string $aliasName): string
    {
        return str_replace($tableName, $aliasName, $field);
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return void
     */
    private function setHeaders(TableConfiguration $config): void
    {
        $config->setHeader([
            PyzCustomerTaskTableMap::COL_ID_CUSTOMER_TASK => self::COL_ID,
            PyzCustomerTaskTableMap::COL_TITLE => self::COL_TITLE,
            PyzCustomerTaskTableMap::COL_DESCRIPTION => self::COL_DESCRIPTION,
            self::COL_TAGS => self::COL_TAGS,
            PyzCustomerTaskTableMap::COL_FK_CREATOR => self::COL_CREATOR,
            PyzCustomerTaskTableMap::COL_FK_OWNER => self::COL_OWNER,
            PyzCustomerTaskTableMap::COL_DUE_DATE => self::COL_DUE_DATE,
            PyzCustomerTaskTableMap::COL_STATUS => self::COL_STATUS,
        ]);
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return void
     */
    private function setSortable(TableConfiguration $config): void
    {
        $config->setSortable([
            PyzCustomerTaskTableMap::COL_ID_CUSTOMER_TASK,
            PyzCustomerTaskTableMap::COL_TITLE,
            PyzCustomerTaskTableMap::COL_STATUS,
        ]);
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return void
     */
    private function setSearchable(TableConfiguration $config): void
    {
        $config->setSearchable([
            PyzCustomerTaskTableMap::COL_TITLE,
            PyzCustomerTaskTableMap::COL_DESCRIPTION,
        ]);
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return void
     */
    private function setRawColumns(TableConfiguration $config): void
    {
        $config->setRawColumns([
            self::COL_TAGS,
        ]);
    }
}
