<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Carts;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Spryker\Glue\CartsRestApi\CartsRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\RequestConstantsInterface;
use Spryker\Glue\ProductsRestApi\ProductsRestApiConfig;
use Spryker\Shared\Price\PriceConfig;
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
 * @SuppressWarnings(\PyzTest\Glue\Carts\PHPMD)
 */
class CartsApiTester extends ApiEndToEndTester
{
    use _generated\CartsApiTesterActions;

    /**
     * @return string
     */
    public function createGuestCustomerReference(): string
    {
        return uniqid('testReference', true);
    }

    /**
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteTransfers
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function createPersistentQuote(
        CartsApiTester $I,
        CustomerTransfer $customerTransfer,
        array $productConcreteTransfers,
    ): QuoteTransfer {
        $quoteTransfer = $I->havePersistentQuote([
            QuoteTransfer::CUSTOMER => $customerTransfer,
            QuoteTransfer::TOTALS => (new TotalsTransfer())
                ->setSubtotal(random_int(1000, 10000))
                ->setPriceToPay(random_int(1000, 10000)),
            QuoteTransfer::ITEMS => $this->mapProductConcreteTransfersToQuoteTransferItems($productConcreteTransfers),
            QuoteTransfer::STORE => [
                StoreTransfer::NAME => 'DE',
                StoreTransfer::DEFAULT_CURRENCY_ISO_CODE => 'EUR',
                StoreTransfer::AVAILABLE_CURRENCY_ISO_CODES => ['EUR'],
            ],
            QuoteTransfer::PRICE_MODE => PriceConfig::PRICE_MODE_GROSS,
        ]);

        $quoteTransfer = $I->getLocator()->cart()->facade()->reloadItems($quoteTransfer);
        $I->getLocator()->quote()->facade()->updateQuote($quoteTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param string $sku
     *
     * @return string|null
     */
    public function getGroupKeyFromQuote(QuoteTransfer $quoteTransfer, string $sku): ?string
    {
        foreach ($quoteTransfer->getItems() as $itemTransfer) {
            if ($itemTransfer->getSku() === $sku) {
                return $itemTransfer->getGroupKey();
            }
        }

        return null;
    }

    /**
     * @param \PyzTest\Glue\Carts\CartsApiTester $I
     * @param string $cartUuid
     * @param array $attributes
     *
     * @return string
     */
    public function createCartResourceEntityTag(
        CartsApiTester $I,
        string $cartUuid,
        array $attributes,
    ): string {
        return $I->haveEntityTag(
            CartsRestApiConfig::RESOURCE_CARTS,
            $cartUuid,
            $attributes,
        );
    }

    /**
     * @param int $quantity
     * @param string $resourceName
     * @param string $itemSku
     *
     * @return void
     */
    public function seeCartItemQuantityEqualsToQuantityInRequest(
        int $quantity,
        string $resourceName,
        string $itemSku,
    ): void {
        $includedByTypeAndId = $this->grabIncludedByTypeAndId($resourceName, $itemSku);

        $this->assertArrayHasKey('quantity', $includedByTypeAndId);
        $this->assertEquals($quantity, $includedByTypeAndId['quantity']);
    }

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
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildCartsUrl(array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceCarts}' . $this->formatQueryInclude($includes),
            [
                'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
            ],
        );
    }

    /**
     * @param string $customerReference
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildCustomerCartUrl(string $customerReference, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{customers}/{customerReference}/{resourceCarts}' . $this->formatQueryInclude($includes),
            [
                'customers' => CartsRestApiConfig::RESOURCE_CUSTOMERS,
                'customerReference' => $customerReference,
                'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
            ],
        );
    }

    /**
     * @param string $cartUuid
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildCartUrl(string $cartUuid, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceCarts}/{cartUuid}' . $this->formatQueryInclude($includes),
            [
                'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                'cartUuid' => $cartUuid,
            ],
        );
    }

    /**
     * @param string $cartUuid
     * @param string $cartItemGroupKey
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildCartItemUrl(string $cartUuid, string $cartItemGroupKey, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceCarts}/{cartUuid}/{resourceCartItems}/{cartItemGroupKey}' . $this->formatQueryInclude($includes),
            [
                'resourceCarts' => CartsRestApiConfig::RESOURCE_CARTS,
                'cartUuid' => $cartUuid,
                'resourceCartItems' => CartsRestApiConfig::RESOURCE_CART_ITEMS,
                'cartItemGroupKey' => $cartItemGroupKey,
            ],
        );
    }

    /**
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildGuestCartsUrl(array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceGuestCarts}' . $this->formatQueryInclude($includes),
            [
                'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
            ],
        );
    }

    /**
     * @param string $guestCartUuid
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildGuestCartUrl(string $guestCartUuid, array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceGuestCarts}/{guestCartUuid}' . $this->formatQueryInclude($includes),
            [
                'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                'guestCartUuid' => $guestCartUuid,
            ],
        );
    }

    /**
     * @param string $guestCartUuid
     * @param string $guestCartItemGroupKey
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildGuestCartItemUrl(
        string $guestCartUuid,
        string $guestCartItemGroupKey,
        array $includes = [],
    ): string {
        return $this->formatFullUrl(
            '{resourceGuestCarts}/{guestCartUuid}/{resourceGuestCartItems}/{guestCartItemGroupKey}' . $this->formatQueryInclude($includes),
            [
                'resourceGuestCarts' => CartsRestApiConfig::RESOURCE_GUEST_CARTS,
                'guestCartUuid' => $guestCartUuid,
                'resourceGuestCartItems' => CartsRestApiConfig::RESOURCE_GUEST_CARTS_ITEMS,
                'guestCartItemGroupKey' => $guestCartItemGroupKey,
            ],
        );
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteTransfers
     *
     * @return array
     */
    protected function mapProductConcreteTransfersToQuoteTransferItems(array $productConcreteTransfers): array
    {
        $quoteTransferItems = [];

        foreach ($productConcreteTransfers as $productConcreteTransfer) {
            $quoteTransferItems[] = [
                ItemTransfer::SKU => $productConcreteTransfer->getSku(),
                ItemTransfer::GROUP_KEY => $productConcreteTransfer->getSku(),
                ItemTransfer::ABSTRACT_SKU => $productConcreteTransfer->getAbstractSku(),
                ItemTransfer::ID_PRODUCT_ABSTRACT => $productConcreteTransfer->getFkProductAbstract(),
                ItemTransfer::UNIT_PRICE => random_int(100, 1000),
                ItemTransfer::UNIT_GROSS_PRICE => random_int(100, 1000),
                ItemTransfer::QUANTITY => 1,
            ];
        }

        return $quoteTransferItems;
    }
}
