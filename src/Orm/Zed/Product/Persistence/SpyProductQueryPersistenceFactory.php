<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Orm\Zed\Product\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class SpyProductQueryPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Product\Persistence\SpyProductQuery
     */
    public function createPyzSpyProductQuery()
    {
        return SpyProductQuery::create();
    }
}
