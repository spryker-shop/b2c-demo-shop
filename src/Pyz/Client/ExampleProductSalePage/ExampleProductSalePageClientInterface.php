<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ExampleProductSalePage;

/**
 * @method \Pyz\Client\ExampleProductSalePage\ExampleProductSalePageFactory getFactory()
 */
interface ExampleProductSalePageClientInterface
{
    /**
     * Specification:
     * - A query based on the request parameters will be executed.
     * - The result contains only products with both DEFAULT and ORIGINAL prices.
     * - The query will also create facet aggregations, pagination and sorting based on the request parameters
     * - The result is a formatted associative array where the used result formatters' name are the keys and their results are the values
     *
     * @api
     *
     * @param array<mixed> $requestParameters
     *
     * @return array<mixed>
     */
    public function saleSearch(array $requestParameters): array;
}
