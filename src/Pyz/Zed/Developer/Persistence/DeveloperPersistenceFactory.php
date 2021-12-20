<?php

namespace Pyz\Zed\Developer\Persistence;

use Orm\Zed\Developer\Persistence\PyzDeveloperQuery;
use Pyz\Zed\Developer\Persistence\Mapper\DeveloperMapper;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class DeveloperPersistenceFactory extends AbstractPersistenceFactory
{

    /**
     * @return PyzDeveloperQuery
     */
    public function createDeveloperQuery(): PyzDeveloperQuery
    {
        return PyzDeveloperQuery::create();
    }

    /**
     * @return DeveloperMapper
     */
    public function createDeveloperMapper(): DeveloperMapper
    {
        return new DeveloperMapper();
    }

}
