<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Orm\Zed\Product\Persistence;

interface SpyProductQueryContainerInterface
{
    /**
     * Generate SpyProductQuery
     *
     * @api
     *
     * @return \Orm\Zed\Product\Persistence\SpyProductQuery
     */
    public function querySpyProduct();
}
