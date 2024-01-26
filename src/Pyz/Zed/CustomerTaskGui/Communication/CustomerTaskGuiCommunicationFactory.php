<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTaskGui\Communication;

use Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery;
use Pyz\Zed\CustomerTaskGui\Communication\Table\CustomerTaskTable;
use Pyz\Zed\CustomerTaskGui\CustomerTaskGuiDependencyProvider;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

class CustomerTaskGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Spryker\Zed\Gui\Communication\Table\AbstractTable
     */
    public function createCustomerTaskTable(): AbstractTable
    {
        return new CustomerTaskTable($this->getCustomerTaskPropelQuery());
    }

    /**
     * @return \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery
     */
    public function getCustomerTaskPropelQuery(): PyzCustomerTaskQuery
    {
        return $this->getProvidedDependency(CustomerTaskGuiDependencyProvider::PROPEL_CUSTOMER_TASK_QUERY);
    }
}
