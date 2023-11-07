<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\AlternativeProducts;

use Spryker\Glue\AlternativeProductsRestApi\AlternativeProductsRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\RequestConstantsInterface;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;
use SprykerTest\Glue\Testify\Tester\ApiEndToEndTester;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(\PyzTest\Glue\AlternativeProducts\PHPMD)
 */
class AlternativeProductsRestApiTester extends ApiEndToEndTester
{
    use _generated\AlternativeProductsRestApiTesterActions;

    /**
     * @param array<string> $includes
     *
     * @return string
     */
    public function formatQueryInclude(array $includes = []): string
    {
        if (!$includes) {
            return '';
        }

        return sprintf('?%s=%s', RequestConstantsInterface::QUERY_INCLUDE, implode(',', $includes));
    }

    /**
     * @param string $productAbstractSku
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildProductAbstractUrl(string $productAbstractSku, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceAbstractProducts}/{productAbstractSku}' . $this->formatQueryInclude($includes),
            [
                'resourceAbstractProducts' => ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
                'productAbstractSku' => $productAbstractSku,
            ],
        );
    }

    /**
     * @param string $productConcreteSku
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildProductConcreteUrl(string $productConcreteSku, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceConcreteProducts}/{productConcreteSku}' . $this->formatQueryInclude($includes),
            [
                'resourceConcreteProducts' => ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                'productConcreteSku' => $productConcreteSku,
            ],
        );
    }

    /**
     * @param string $productConcreteSku
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildAbstractAlternativeProductsUrl(string $productConcreteSku, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceConcreteProducts}/{productConcreteSku}/{resourceAbstractAlternativeProducts}' . $this->formatQueryInclude($includes),
            [
                'resourceConcreteProducts' => ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                'resourceAbstractAlternativeProducts' => AlternativeProductsRestApiConfig::RELATIONSHIP_NAME_ABSTRACT_ALTERNATIVE_PRODUCTS,
                'productConcreteSku' => $productConcreteSku,
            ],
        );
    }

    /**
     * @param string $productConcreteSku
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildConcreteAlternativeProductsUrl(string $productConcreteSku, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceConcreteProducts}/{productConcreteSku}/{resourceConcreteAlternativeProducts}' . $this->formatQueryInclude($includes),
            [
                'resourceConcreteProducts' => ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                'resourceConcreteAlternativeProducts' => AlternativeProductsRestApiConfig::RELATIONSHIP_NAME_CONCRETE_ALTERNATIVE_PRODUCTS,
                'productConcreteSku' => $productConcreteSku,
            ],
        );
    }
}
