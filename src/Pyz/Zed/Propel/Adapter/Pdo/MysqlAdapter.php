<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Propel\Adapter\Pdo;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Adapter\Pdo\MysqlAdapter as PropelMysqlAdapter;

class MysqlAdapter extends PropelMysqlAdapter
{
    /**
     * Duplicating logic from {@link \Propel\Runtime\Adapter\Pdo\PgsqlAdapter::getGroupBy} to keep the behavior the same.
     *
     * @param \Propel\Runtime\ActiveQuery\Criteria $criteria
     *
     * @return string
     */
    public function getGroupBy(Criteria $criteria)
    {
        $groupBy = $criteria->getGroupByColumns();

        if ($groupBy) {
            // check if all selected columns are groupBy'ed.
            $selected = $this->getPlainSelectedColumns($criteria);
            $asSelects = $criteria->getAsColumns();

            foreach ($selected as $colName) {
                if (!in_array($colName, $groupBy)) {
                    // is a alias there that is grouped?
                    $alias = array_search($colName, $asSelects);
                    if ($alias) {
                        if (in_array($alias, $groupBy)) {
                            continue; //yes, alias is selected.
                        }
                    }
                    $groupBy[] = $colName;
                }
            }
        }

        if ($groupBy) {
            return ' GROUP BY ' . implode(',', $groupBy);
        }

        return '';
    }
}
