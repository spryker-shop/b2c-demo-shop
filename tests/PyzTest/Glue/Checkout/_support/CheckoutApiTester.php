<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Checkout;

use DateTime;
use Generated\Shared\DataBuilder\AddressBuilder;
use Generated\Shared\DataBuilder\CustomerBuilder;
use Generated\Shared\DataBuilder\ItemBuilder;
use Generated\Shared\DataBuilder\ShipmentBuilder;
use Generated\Shared\DataBuilder\StoreRelationBuilder;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PaymentMethodTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestAddressTransfer;
use Generated\Shared\Transfer\RestCheckoutDataTransfer;
use Generated\Shared\Transfer\RestCheckoutResponseTransfer;
use Generated\Shared\Transfer\RestCustomerTransfer;
use Generated\Shared\Transfer\RestOrderDetailsAttributesTransfer;
use Generated\Shared\Transfer\RestPaymentTransfer;
use Generated\Shared\Transfer\RestShipmentsTransfer;
use Generated\Shared\Transfer\RestShipmentTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use Generated\Shared\Transfer\StockProductTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use Spryker\Glue\CheckoutRestApi\CheckoutRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\RequestConstantsInterface;
use Spryker\Glue\OrdersRestApi\OrdersRestApiConfig;
use Spryker\Shared\Price\PriceConfig;
use Spryker\Shared\Shipment\ShipmentConfig;
use Spryker\Zed\Cart\Business\CartFacadeInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;
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
 * @SuppressWarnings(\PyzTest\Glue\Checkout\PHPMD)
 */
class CheckoutApiTester extends ApiEndToEndTester
{
    use _generated\CheckoutApiTesterActions;

    /**
     * @var string
     */
    protected const REQUEST_PARAM_PAYMENT_METHOD_NAME_INVOICE = 'Invoice';

    /**
     * @var string
     */
    protected const REQUEST_PARAM_PAYMENT_PROVIDER_NAME_DUMMY_PAYMENT = 'DummyPayment';

    /**
     * @var string
     */
    protected const QUOTE_ITEM_OVERRIDE_DATA_PRODUCT = 'product';

    /**
     * @var string
     */
    protected const QUOTE_ITEM_OVERRIDE_DATA_SHIPMENT = 'shipment';

    /**
     * @var string
     */
    protected const QUOTE_ITEM_OVERRIDE_DATA_QUANTITY = 'quantity';

    /**
     * @var int
     */
    protected const DEFAULT_QUOTE_ITEM_QUANTITY = 10;

    /**
     * @return void
     */
    public function assertCheckoutResponseResourceHasCorrectData(): void
    {
        $this->amSure('The returned resource id should be null')
            ->whenI()
            ->seeSingleResourceIdEqualTo('');

        $attributes = $this->getDataFromResponseByJsonPath('$.data.attributes');

        $this->assertNotEmpty(
            $attributes[RestCheckoutResponseTransfer::ORDER_REFERENCE],
            'The returned resource attributes order reference should not be empty',
        );
        $this->assertArrayHasKey(
            RestCheckoutResponseTransfer::IS_EXTERNAL_REDIRECT,
            $attributes,
            'The returned resource attributes should have an external redirect key',
        );
        $this->assertArrayHasKey(
            RestCheckoutResponseTransfer::REDIRECT_URL,
            $attributes,
            'The returned resource attributes should have a redirect URL key',
        );
    }

    /**
     * @return void
     */
    public function assertCheckoutDataResponseResourceHasCorrectData(): void
    {
        $this->amSure('The returned resource id should be null')
            ->whenI()
            ->seeSingleResourceIdEqualTo('');

        $attributes = $this->getDataFromResponseByJsonPath('$.data.attributes');

        $this->assertEmpty(
            $attributes[RestCheckoutDataTransfer::ADDRESSES],
            'The returned resource attributes addresses should be an empty array',
        );
    }

    /**
     * @param int $price
     *
     * @return void
     */
    public function assertShipmentExpensesHaveCorrectPrice(int $price): void
    {
        $this->amSure('The returned resource should have included orders resource')
            ->whenI()
            ->seeIncludesContainResourceOfType(OrdersRestApiConfig::RESOURCE_ORDERS);

        $ordersAttributes = $this->getDataFromResponseByJsonPath(
            sprintf('$.included[?(@.type == %1$s)].attributes', json_encode(OrdersRestApiConfig::RESOURCE_ORDERS)),
        );

        $this->assertNotNull($ordersAttributes);
        $this->assertCount(1, $ordersAttributes);
        $restOrdersDetailsAttributesTransfer = (new RestOrderDetailsAttributesTransfer())->fromArray($ordersAttributes[0], true);
        $this->assertCount(1, $restOrdersDetailsAttributesTransfer->getExpenses());

        /** @var \Generated\Shared\Transfer\RestOrderExpensesAttributesTransfer $restOrderExpensesAttributesTransfer */
        $restOrderExpensesAttributesTransfer = $restOrdersDetailsAttributesTransfer->getExpenses()->getIterator()->current();
        $this->assertSame(ShipmentConfig::SHIPMENT_EXPENSE_TYPE, $restOrderExpensesAttributesTransfer->getType());
        $this->assertSame($price, $restOrderExpensesAttributesTransfer->getSumPrice());
    }

    /**
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildCheckoutUrl(array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceCheckout}' . $this->formatQueryInclude($includes),
            [
                'resourceCheckout' => CheckoutRestApiConfig::RESOURCE_CHECKOUT,
            ],
        );
    }

    /**
     * @param array<string> $includes
     *
     * @return string
     */
    public function buildCheckoutDataUrl(array $includes = []): string
    {
        return $this->formatFullUrl(
            '{resourceCheckoutData}' . $this->formatQueryInclude($includes),
            [
                'resourceCheckoutData' => CheckoutRestApiConfig::RESOURCE_CHECKOUT_DATA,
            ],
        );
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    public function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getLocator()
            ->store()
            ->facade();
    }

    /**
     * @return \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    public function getCustomerFacade(): CustomerFacadeInterface
    {
        return $this->getLocator()
            ->customer()
            ->facade();
    }

    /**
     * @return \Spryker\Zed\Cart\Business\CartFacadeInterface
     */
    public function getCartFacade(): CartFacadeInterface
    {
        return $this->getLocator()->cart()->facade();
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return array
     */
    public function getAddressRequestPayload(AddressTransfer $addressTransfer): array
    {
        return [
            RestAddressTransfer::SALUTATION => $addressTransfer->getSalutation(),
            RestAddressTransfer::FIRST_NAME => $addressTransfer->getFirstName(),
            RestAddressTransfer::LAST_NAME => $addressTransfer->getLastName(),
            RestAddressTransfer::ADDRESS1 => $addressTransfer->getAddress1(),
            RestAddressTransfer::ADDRESS2 => $addressTransfer->getAddress2(),
            RestAddressTransfer::ADDRESS3 => $addressTransfer->getAddress3(),
            RestAddressTransfer::ZIP_CODE => $addressTransfer->getZipCode(),
            RestAddressTransfer::CITY => $addressTransfer->getCity(),
            RestAddressTransfer::ISO2_CODE => $addressTransfer->getIso2Code(),
            RestAddressTransfer::PHONE => $addressTransfer->getPhone(),
            RestCustomerTransfer::EMAIL => $addressTransfer->getEmail(),
            RestAddressTransfer::IS_DEFAULT_BILLING => $addressTransfer->getIsDefaultBilling(),
            RestAddressTransfer::IS_DEFAULT_SHIPPING => $addressTransfer->getIsDefaultShipping(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return array
     */
    public function getCustomerRequestPayload(CustomerTransfer $customerTransfer): array
    {
        return [
            RestCustomerTransfer::SALUTATION => $customerTransfer->getSalutation(),
            RestCustomerTransfer::FIRST_NAME => $customerTransfer->getFirstName(),
            RestCustomerTransfer::LAST_NAME => $customerTransfer->getLastName(),
            RestCustomerTransfer::EMAIL => $customerTransfer->getEmail(),
        ];
    }

    /**
     * @param string $paymentMethodName
     * @param string $paymentProviderName
     *
     * @return array
     */
    public function getPaymentRequestPayload(
        string $paymentMethodName = self::REQUEST_PARAM_PAYMENT_METHOD_NAME_INVOICE,
        string $paymentProviderName = self::REQUEST_PARAM_PAYMENT_PROVIDER_NAME_DUMMY_PAYMENT,
    ): array {
        return [
            [
                RestPaymentTransfer::PAYMENT_METHOD_NAME => $paymentMethodName,
                RestPaymentTransfer::PAYMENT_PROVIDER_NAME => $paymentProviderName,
            ],
        ];
    }

    /**
     * @param int $idShipmentMethod
     *
     * @return array
     */
    public function getShipmentRequestPayload(int $idShipmentMethod): array
    {
        return [
            RestShipmentTransfer::ID_SHIPMENT_METHOD => $idShipmentMethod,
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\AddressTransfer|null $addressTransfer
     *
     * @return array<string, mixed>
     */
    public function getSplitShipmentRequestPayload(ItemTransfer $itemTransfer, ?AddressTransfer $addressTransfer = null): array
    {
        $shippingAddressPayload = $addressTransfer
            ? [RestAddressTransfer::ID => $addressTransfer->getUuidOrFail()]
            : $this->getAddressRequestPayload($itemTransfer->getShipmentOrFail()->getShippingAddressOrFail());

        return [
            RestShipmentsTransfer::ID_SHIPMENT_METHOD => $itemTransfer->getShipmentOrFail()->getMethodOrFail()->getIdShipmentMethodOrFail(),
            RestShipmentsTransfer::ITEMS => [$itemTransfer->getGroupKeyOrFail()],
            RestShipmentsTransfer::SHIPPING_ADDRESS => $shippingAddressPayload,
            RestShipmentsTransfer::REQUESTED_DELIVERY_DATE => (new DateTime('tomorrow'))->format('Y-m-d'),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer
     * @param \Generated\Shared\Transfer\ShipmentMethodTransfer $shipmentMethodTransfer
     * @param int $quantity
     *
     * @return array
     */
    public function getQuoteItemOverrideData(
        ProductConcreteTransfer $productConcreteTransfer,
        ShipmentMethodTransfer $shipmentMethodTransfer,
        int $quantity = self::DEFAULT_QUOTE_ITEM_QUANTITY,
    ): array {
        return [
            static::QUOTE_ITEM_OVERRIDE_DATA_PRODUCT => $productConcreteTransfer,
            static::QUOTE_ITEM_OVERRIDE_DATA_SHIPMENT => [
                ShipmentTransfer::METHOD => $shipmentMethodTransfer,
            ],
            static::QUOTE_ITEM_OVERRIDE_DATA_QUANTITY => $quantity,
        ];
    }

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
     * @return string
     */
    public function createGuestCustomerReference(): string
    {
        return uniqid('testReference', true);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteTransfers
     * @param array $overrideShipment
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function havePersistentQuoteWithItems(
        CustomerTransfer $customerTransfer,
        array $productConcreteTransfers,
        array $overrideShipment = [],
    ): QuoteTransfer {
        $shipmentTransfer = (new ShipmentBuilder($overrideShipment))
            ->withMethod()
            ->withShippingAddress();

        return $this->havePersistentQuote([
            QuoteTransfer::CUSTOMER => $customerTransfer,
            QuoteTransfer::TOTALS => (new TotalsTransfer())
                ->setSubtotal(random_int(1000, 10000))
                ->setPriceToPay(random_int(1000, 10000)),
            QuoteTransfer::ITEMS => $this->mapProductConcreteTransfersToQuoteTransferItems($productConcreteTransfers),
            QuoteTransfer::STORE => [StoreTransfer::NAME => 'DE'],
            QuoteTransfer::PRICE_MODE => PriceConfig::PRICE_MODE_GROSS,
            QuoteTransfer::BILLING_ADDRESS => (new AddressBuilder())->build(),
            QuoteTransfer::SHIPMENT => $shipmentTransfer,
        ]);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param array $overrideItems
     * @param string $priceMode
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function havePersistentQuoteWithItemsAndItemLevelShipment(
        CustomerTransfer $customerTransfer,
        array $overrideItems = [],
        string $priceMode = PriceConfig::PRICE_MODE_GROSS,
    ): QuoteTransfer {
        return $this->havePersistentQuote([
            QuoteTransfer::CUSTOMER => $customerTransfer,
            QuoteTransfer::TOTALS => (new TotalsTransfer())
                ->setSubtotal(random_int(1000, 10000))
                ->setPriceToPay(random_int(1000, 10000)),
            QuoteTransfer::ITEMS => $this->mapProductConcreteTransfersToQuoteTransferItemsWithItemLevelShipment($overrideItems),
            QuoteTransfer::STORE => [StoreTransfer::NAME => 'DE'],
            QuoteTransfer::PRICE_MODE => $priceMode,
            QuoteTransfer::BILLING_ADDRESS => (new AddressBuilder())->build(),
        ]);
    }

    /**
     * @param array $overrideCustomer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function haveEmptyPersistentQuote(array $overrideCustomer = []): QuoteTransfer
    {
        return $this->havePersistentQuote([
            QuoteTransfer::CUSTOMER => (new CustomerBuilder($overrideCustomer))->build(),
            QuoteTransfer::BILLING_ADDRESS => (new AddressBuilder())->build(),
        ]);
    }

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function haveProductWithStock(): ProductConcreteTransfer
    {
        $productConcreteTransfer = $this->haveFullProduct();

        $this->haveProductInStockForStore($this->getStoreFacade()->getCurrentStore(), [
            StockProductTransfer::SKU => $productConcreteTransfer->getSku(),
            StockProductTransfer::IS_NEVER_OUT_OF_STOCK => 1,
        ]);

        $priceProductOverride = [
            PriceProductTransfer::SKU_PRODUCT_ABSTRACT => $productConcreteTransfer->getAbstractSku(),
            PriceProductTransfer::SKU_PRODUCT => $productConcreteTransfer->getSku(),
            PriceProductTransfer::ID_PRODUCT => $productConcreteTransfer->getIdProductConcrete(),
            PriceProductTransfer::PRICE_TYPE_NAME => 'DEFAULT',
            PriceProductTransfer::MONEY_VALUE => [
                MoneyValueTransfer::NET_AMOUNT => 770,
                MoneyValueTransfer::GROSS_AMOUNT => 880,
            ],
        ];
        $this->havePriceProduct($priceProductOverride);

        return $productConcreteTransfer;
    }

    /**
     * @param array $override
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function createCustomerTransfer(array $override = []): CustomerTransfer
    {
        return (new CustomerBuilder($override))->build();
    }

    /**
     * @param array $override
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function haveCustomerWithPersistentAddress(array $override = []): CustomerTransfer
    {
        $customerTransfer = $this->haveCustomer($override);

        return $this->haveAddressForCustomer($customerTransfer);
    }

    /**
     * @param array $paymentMethodOverrideData
     * @param array $storeOverrideData
     *
     * @return \Generated\Shared\Transfer\PaymentMethodTransfer
     */
    public function havePaymentMethodWithStore(
        array $paymentMethodOverrideData = [],
        array $storeOverrideData = [
            StoreTransfer::NAME => 'DE',
            StoreTransfer::DEFAULT_CURRENCY_ISO_CODE => 'EUR',
            StoreTransfer::AVAILABLE_CURRENCY_ISO_CODES => ['EUR'],
        ],
    ): PaymentMethodTransfer {
        $storeTransfer = $this->haveStore($storeOverrideData);
        $storeRelationTransfer = (new StoreRelationBuilder())->seed([
            StoreRelationTransfer::ID_STORES => [
                $storeTransfer->getIdStore(),
            ],
            StoreRelationTransfer::STORES => [
                $storeTransfer,
            ],
        ])->build();

        $paymentMethodOverrideData = array_merge($paymentMethodOverrideData, [PaymentMethodTransfer::STORE_RELATION => $storeRelationTransfer]);

        return $this->havePaymentMethod($paymentMethodOverrideData);
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return void
     */
    public function assertCustomerBillingAddressInOrders(AddressTransfer $addressTransfer): void
    {
        $jsonPath = sprintf('$..included[?(@.type == \'%s\')]', 'orders');
        $billingAddress = $this->getDataFromResponseByJsonPath($jsonPath)[0]['attributes']['billingAddress'];

        $this->assertSame($addressTransfer->getAddress1(), $billingAddress['address1']);
        $this->assertSame($addressTransfer->getAddress2(), $billingAddress['address2']);
        $this->assertSame($addressTransfer->getAddress3(), $billingAddress['address3']);
        $this->assertSame($addressTransfer->getCompany(), $billingAddress['company']);
        $this->assertSame($addressTransfer->getCity(), $billingAddress['city']);
        $this->assertSame($addressTransfer->getZipCode(), $billingAddress['zipCode']);
        $this->assertSame($addressTransfer->getIso2Code(), $billingAddress['iso2Code']);
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return void
     */
    public function assertCustomerShippingAddressInOrderShipments(
        AddressTransfer $addressTransfer,
    ): void {
        $jsonPath = sprintf('$..included[?(@.type == \'%s\')]', 'order-shipments');
        $shippingAddress = $this->getDataFromResponseByJsonPath($jsonPath)[0]['attributes']['shippingAddress'];

        $this->assertSame($addressTransfer->getAddress1(), $shippingAddress['address1']);
        $this->assertSame($addressTransfer->getAddress2(), $shippingAddress['address2']);
        $this->assertSame($addressTransfer->getAddress3(), $shippingAddress['address3']);
        $this->assertSame($addressTransfer->getCompany(), $shippingAddress['company']);
        $this->assertSame($addressTransfer->getCity(), $shippingAddress['city']);
        $this->assertSame($addressTransfer->getZipCode(), $shippingAddress['zipCode']);
        $this->assertSame($addressTransfer->getIso2Code(), $shippingAddress['iso2Code']);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function haveAddressForCustomer(CustomerTransfer $customerTransfer): CustomerTransfer
    {
        $addressTransfer = (new AddressBuilder([
            AddressTransfer::EMAIL => $customerTransfer->getEmail(),
            AddressTransfer::FK_CUSTOMER => $customerTransfer->getIdCustomer(),
            AddressTransfer::FIRST_NAME => $customerTransfer->getFirstName(),
            AddressTransfer::LAST_NAME => $customerTransfer->getLastName(),
        ]))->build();
        $customerFacade = $this->getCustomerFacade();
        $customerFacade->createAddress($addressTransfer);

        return $customerFacade->getCustomer($customerTransfer);
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
            $quoteTransferItems[] = (new ItemBuilder([
                ItemTransfer::SKU => $productConcreteTransfer->getSku(),
                ItemTransfer::GROUP_KEY => $productConcreteTransfer->getSku(),
                ItemTransfer::ABSTRACT_SKU => $productConcreteTransfer->getAbstractSku(),
                ItemTransfer::ID_PRODUCT_ABSTRACT => $productConcreteTransfer->getFkProductAbstract(),
                ItemTransfer::QUANTITY => static::DEFAULT_QUOTE_ITEM_QUANTITY,
            ]))->build()
                ->modifiedToArray();
        }

        return $quoteTransferItems;
    }

    /**
     * @param array $overrideItems
     *
     * @return array
     */
    protected function mapProductConcreteTransfersToQuoteTransferItemsWithItemLevelShipment(array $overrideItems = []): array
    {
        $quoteTransferItems = [];

        foreach ($overrideItems as $overrideItem) {
            $productConcreteTransfer = $this->getProductConcreteTransferFromOverrideItemData($overrideItem);
            $overrideShipment = $this->getOverrideShipmentDataFromOverrideItemData($overrideItem);

            $quoteTransferItems[] = (new ItemBuilder([
                ItemTransfer::SKU => $productConcreteTransfer->getSku(),
                ItemTransfer::GROUP_KEY => $productConcreteTransfer->getSku(),
                ItemTransfer::ABSTRACT_SKU => $productConcreteTransfer->getAbstractSku(),
                ItemTransfer::ID_PRODUCT_ABSTRACT => $productConcreteTransfer->getFkProductAbstract(),
                ItemTransfer::QUANTITY => $this->getQuoteItemQuantityFromOverrideItemData($overrideItem),
            ]))->withShipment((new ShipmentBuilder($overrideShipment))
                ->withMethod()
                ->withShippingAddress())
                ->build()
                ->modifiedToArray();
        }

        return $quoteTransferItems;
    }

    /**
     * @param array $overrideItem
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected function getProductConcreteTransferFromOverrideItemData(array $overrideItem): ProductConcreteTransfer
    {
        return $overrideItem[static::QUOTE_ITEM_OVERRIDE_DATA_PRODUCT];
    }

    /**
     * @param array $overrideItem
     *
     * @return array
     */
    protected function getOverrideShipmentDataFromOverrideItemData(array $overrideItem): array
    {
        return $overrideItem[static::QUOTE_ITEM_OVERRIDE_DATA_SHIPMENT];
    }

    /**
     * @param array $overrideItem
     *
     * @return int
     */
    protected function getQuoteItemQuantityFromOverrideItemData(array $overrideItem): int
    {
        return $overrideItem[static::QUOTE_ITEM_OVERRIDE_DATA_QUANTITY] ?? static::DEFAULT_QUOTE_ITEM_QUANTITY;
    }

    /**
     * @param array<string> $includes
     *
     * @return string
     */
    protected function formatQueryInclude(array $includes = []): string
    {
        if (!$includes) {
            return '';
        }

        return sprintf('?%s=%s', RequestConstantsInterface::QUERY_INCLUDE, implode(',', $includes));
    }
}
