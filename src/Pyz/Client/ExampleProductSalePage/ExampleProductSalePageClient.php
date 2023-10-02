<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Client\ExampleProductSalePage;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\ExampleProductSalePage\ExampleProductSalePageFactory getFactory()
 */
class ExampleProductSalePageClient extends AbstractClient implements ExampleProductSalePageClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<mixed> $requestParameters
     *
     * @return array<mixed>
     */
    public function saleSearch(array $requestParameters = []): array
    {
        $searchQuery = $this->getFactory()->getSaleSearchQueryPlugin($requestParameters);
        $resultFormatters = $this->getFactory()->getSaleSearchResultFormatterPlugins();

        return $this->getFactory()
            ->getSearchClient()
            ->search($searchQuery, $resultFormatters, $requestParameters);
    }
}
