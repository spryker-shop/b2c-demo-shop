<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\Catalog;

use Spryker\Client\Catalog\CatalogConfig as SprykerCatalogConfig;

class CatalogConfig extends SprykerCatalogConfig
{
    /**
     * @var array<int>
     */
    protected const PAGINATION_VALID_ITEMS_PER_PAGE = [
        10,
        1000,
    ];

    /**
     * @var int
     */
    protected const PAGINATION_CATALOG_SEARCH_DEFAULT_ITEMS_PER_PAGE = 12;
}
