<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ExampleProductSalePage\Persistence;

use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabelProductAbstractQuery;
use Orm\Zed\ProductLabel\Persistence\SpyProductLabelQuery;

/**
 * @method \Pyz\Zed\ExampleProductSalePage\Persistence\ExampleProductSalePagePersistenceFactory getFactory()
 */
interface ExampleProductSalePageQueryContainerInterface
{
    /**
     * @api
     */
    public function queryProductLabelByName(string $labelName): SpyProductLabelQuery;

    /**
     * @api
     */
    public function queryRelationsBecomingInactive(int $idProductLabel, string $priceMode): SpyProductLabelProductAbstractQuery;

    /**
     * @api
     */
    public function queryRelationsBecomingActive(
        int $idProductLabel,
        int $currentStoreId,
        int $currentCurrencyId,
        string $priceMode,
    ): SpyProductAbstractQuery;
}
