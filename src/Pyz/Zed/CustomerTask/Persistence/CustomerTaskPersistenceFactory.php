<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Persistence;

use Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery;
use Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskTagQuery;
use Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskTagRelationQuery;
use Pyz\Zed\CustomerTask\Persistence\Propel\Mapper\CustomerTaskMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\CustomerTask\CustomerTaskConfig getConfig()
 * @method \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface getEntityManager()
 */
class CustomerTaskPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskQuery
     */
    public function getCustomerTaskPropelQuery(): PyzCustomerTaskQuery
    {
        return PyzCustomerTaskQuery::create();
    }

    /**
     * @return \Pyz\Zed\CustomerTask\Persistence\Propel\Mapper\CustomerTaskMapper
     */
    public function createCustomerTaskMapper(): CustomerTaskMapper
    {
        return new CustomerTaskMapper();
    }

    /**
     * @return \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskTagQuery
     */
    public function getCustomerTaskTagPropelQuery(): PyzCustomerTaskTagQuery
    {
        return PyzCustomerTaskTagQuery::create();
    }

    /**
     * @return \Orm\Zed\CustomerTask\Persistence\PyzCustomerTaskTagRelationQuery
     */
    public function getCustomerTaskTagRelationPropelQuery(): PyzCustomerTaskTagRelationQuery
    {
        return PyzCustomerTaskTagRelationQuery::create();
    }
}
