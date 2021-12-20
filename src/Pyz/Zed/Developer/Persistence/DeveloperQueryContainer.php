<?php

namespace Pyz\Zed\Developer\Persistence;

use Orm\Zed\Developer\Persistence\PyzDeveloperQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

class DeveloperQueryContainer extends AbstractQueryContainer implements DeveloperQueryContainerInterface
{

    /**
     * @return PyzDeveloperQuery
     */
    public function queryDeveloper(): PyzDeveloperQuery
    {
        return $this->getFactory()->createDeveloperQuery();
    }

}
