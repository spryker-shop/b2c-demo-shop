<?php

namespace Pyz\Zed\Developer\Persistence;

use Orm\Zed\Developer\Persistence\PyzDeveloperQuery;

interface DeveloperQueryContainerInterface
{
    /**
     * @return PyzDeveloperQuery
     */
    public function queryDeveloper(): PyzDeveloperQuery;

}
