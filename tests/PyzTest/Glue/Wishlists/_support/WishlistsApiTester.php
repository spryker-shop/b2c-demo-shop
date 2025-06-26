<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Wishlists;

use Spryker\Glue\GlueApplication\Rest\RequestConstantsInterface;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;
use Spryker\Glue\WishlistsRestApi\WishlistsRestApiConfig;
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
 * @SuppressWarnings(\PyzTest\Glue\Wishlists\PHPMD)
 */
class WishlistsApiTester extends ApiEndToEndTester
{
    use _generated\WishlistsApiTesterActions;

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
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildWishlistsUrl(array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceWishlists}' . $this->formatQueryInclude($includes),
            [
                'resourceWishlists' => WishlistsRestApiConfig::RESOURCE_WISHLISTS,
            ],
        );
    }

    /**
     * @param string $wishlistUuid
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildWishlistUrl(string $wishlistUuid, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceWishlists}/{wishlistUuid}' . $this->formatQueryInclude($includes),
            [
                'resourceWishlists' => WishlistsRestApiConfig::RESOURCE_WISHLISTS,
                'wishlistUuid' => $wishlistUuid,
            ],
        );
    }

    /**
     * @param string $wishlistUuid
     * @param string $productConcreteSku
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildWishlistItemUrl(string $wishlistUuid, string $productConcreteSku, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceWishlists}/{wishlistUuid}/{resourceWishlistItems}/{productConcreteSku}' . $this->formatQueryInclude($includes),
            [
                'resourceWishlists' => WishlistsRestApiConfig::RESOURCE_WISHLISTS,
                'wishlistUuid' => $wishlistUuid,
                'resourceWishlistItems' => WishlistsRestApiConfig::RESOURCE_WISHLIST_ITEMS,
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
}
