<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\OrderAmendments;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\StockProductTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Glue\CartReorderRestApi\CartReorderRestApiConfig;
use SprykerTest\Glue\Testify\Tester\ApiEndToEndTester;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
 */
class OrderAmendmentsApiTester extends ApiEndToEndTester
{
    use _generated\OrderAmendmentsApiTesterActions;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function authorizeCustomerToGlue(CustomerTransfer $customerTransfer): void
    {
        $oauthResponseTransfer = $this->haveAuthorizationToGlue($customerTransfer);
        $this->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());
    }

    /**
     * @param string $orderReference
     *
     * @return void
     */
    public function assertResponseContainsAmendmentOrderReference(string $orderReference): void
    {
        $attributes = $this->getDataFromResponseByJsonPath('$.data.attributes');

        $this->assertArrayHasKey('amendmentOrderReference', $attributes);
        $this->assertSame($orderReference, $attributes['amendmentOrderReference']);
    }

    /**
     * @return string
     */
    public function getCartReorderUrl(): string
    {
        return $this->formatUrl('{cartReorderResource}?include=items', [
            'cartReorderResource' => CartReorderRestApiConfig::RESOURCE_CART_REORDER,
        ]);
    }

    /**
     * @param string $sku
     *
     * @return string
     */
    public function getConcreteProductPricesUrl(string $sku): string
    {
        return $this->formatUrl('concrete-products/{sku}/concrete-product-prices', ['sku' => $sku]);
    }

    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(): StoreTransfer
    {
        return $this->getLocator()->store()->facade()->getCurrentStore();
    }

    /**
     * @param int|null $unitPrice
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function haveProductWithPriceAndStock(?int $unitPrice = 10000): ProductConcreteTransfer
    {
        $storeTransfer = $this->getLocator()->store()->facade()->getCurrentStore();
        $productConcreteTransfer = $this->haveFullProduct();

        $this->haveProductInStockForStore($storeTransfer, [
            StockProductTransfer::SKU => $productConcreteTransfer->getSku(),
            StockProductTransfer::IS_NEVER_OUT_OF_STOCK => 1,
        ]);

        $priceProductTransfer = $this->havePriceProduct([
            PriceProductTransfer::SKU_PRODUCT_ABSTRACT => $productConcreteTransfer->getAbstractSku(),
            PriceProductTransfer::SKU_PRODUCT => $productConcreteTransfer->getSku(),
            PriceProductTransfer::ID_PRODUCT => $productConcreteTransfer->getIdProductConcrete(),
            PriceProductTransfer::PRICE_TYPE_NAME => 'DEFAULT',
            PriceProductTransfer::MONEY_VALUE => [
                MoneyValueTransfer::NET_AMOUNT => $unitPrice,
                MoneyValueTransfer::GROSS_AMOUNT => $unitPrice,
            ],
        ]);

        $productConcreteTransfer->addPrice($priceProductTransfer);

        return $productConcreteTransfer;
    }
}
