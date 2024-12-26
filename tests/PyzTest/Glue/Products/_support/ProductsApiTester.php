<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Products;

use Spryker\Glue\GlueApplication\Rest\RequestConstantsInterface;
use Spryker\Glue\ProductPricesRestApi\ProductPricesRestApiConfig;
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
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(\PyzTest\Glue\Products\PHPMD)
 */
class ProductsApiTester extends ApiEndToEndTester
{
    use _generated\ProductsApiTesterActions;

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
     * @param string $productAbstractSku
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildProductAbstractPricesUrl(string $productAbstractSku, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceAbstractProducts}/{productAbstractSku}/{resourceAbstractProductPrices}' . $this->formatQueryInclude($includes),
            [
                'resourceAbstractProducts' => ProductsRestApiConfig::RESOURCE_ABSTRACT_PRODUCTS,
                'productAbstractSku' => $productAbstractSku,
                'resourceAbstractProductPrices' => ProductPricesRestApiConfig::RESOURCE_ABSTRACT_PRODUCT_PRICES,
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
    public function buildProductConcretePricesUrl(string $productConcreteSku, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceConcreteProducts}/{productConcreteSku}/{resourceConcreteProductPrices}' . $this->formatQueryInclude($includes),
            [
                'resourceConcreteProducts' => ProductsRestApiConfig::RESOURCE_CONCRETE_PRODUCTS,
                'productConcreteSku' => $productConcreteSku,
                'resourceConcreteProductPrices' => ProductPricesRestApiConfig::RESOURCE_CONCRETE_PRODUCT_PRICES,
            ],
        );
    }
}
