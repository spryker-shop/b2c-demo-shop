<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\ProductConfigurations\RestApi\Fixtures;

use Generated\Shared\DataBuilder\ProductConfigurationInstanceBuilder;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductConfigurationInstanceTransfer;
use Generated\Shared\Transfer\ProductConfigurationTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use PyzTest\Glue\ProductConfigurations\ProductConfigurationsApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class ProductConfigurationsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    public const PRODUCT_CONFIGURATION_INSTANCE_ATTRIBUTE_JSON_PATH = '.productConfigurationInstance';

    /**
     * @var array<string, mixed>
     */
    public const PRODUCT_CONFIGURATION_CART_ITEM_DATA = [
        'displayData' => self::TEST_DISPLAY_DATA,
        'configuration' => self::TEST_CONFIGURATION,
        'configuratorKey' => self::TEST_CONFIGURATOR_KEY,
        'isComplete' => false,
        'quantity' => 5,
        'availableQuantity' => 100,
        'prices' => [
            [
                'priceTypeName' => 'DEFAULT',
                'netAmount' => 23434,
                'grossAmount' => 42502,
                'currency' => [
                    'code' => 'EUR',
                    'name' => 'Euro',
                    'symbol' => '€',
                ],
                'volumePrices' => [
                    [
                        'netAmount' => 150,
                        'grossAmount' => 165,
                        'quantity' => 5,
                    ],
                    [
                        'netAmount' => 145,
                        'grossAmount' => 158,
                        'quantity' => 10,
                    ],
                    [
                        'netAmount' => 140,
                        'grossAmount' => 152,
                        'quantity' => 20,
                    ],
                ],
            ],
        ],
    ];

    /**
     * @var string
     */
    public const STORE_NAME_DE = 'DE';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    /**
     * @var string
     */
    protected const TEST_CONFIGURATOR_KEY = 'DATE_TIME_CONFIGURATOR';

    /**
     * @var string
     */
    protected const TEST_CONFIGURATION = '{"time_of_day": "2"}';

    /**
     * @var string
     */
    protected const TEST_DISPLAY_DATA = '{"Preferred time of the day": "Afternoon", "Date": "9.09.2020"}';

    protected ProductConcreteTransfer $productConcreteTransfer;

    protected ProductConfigurationTransfer $productConfigurationTransfer;

    protected CustomerTransfer $customerTransfer;

    protected SaveOrderTransfer $saveOrderTransfer;

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function getProductConfigurationTransfer(): ProductConfigurationTransfer
    {
        return $this->productConfigurationTransfer;
    }

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    public function getSaveOrderTransfer(): SaveOrderTransfer
    {
        return $this->saveOrderTransfer;
    }

    public function buildFixtures(ProductConfigurationsApiTester $I): FixturesContainerInterface
    {
        $this->createProductConcrete($I);
        $this->createProductConfiguration($I);
        $this->createCustomerTransfer($I);
        $this->createOrder($I);

        return $this;
    }

    public function createQuoteTransfer(
        CustomerTransfer $customerTransfer,
        ProductConcreteTransfer $productConcreteTransfer,
        ProductConfigurationInstanceTransfer $productConfigurationInstanceTransfer,
    ): QuoteTransfer {
        return (new QuoteBuilder())
            ->withItem([
                ItemTransfer::PRODUCT_CONFIGURATION_INSTANCE => $productConfigurationInstanceTransfer->toArray(),
                ItemTransfer::SKU => $productConcreteTransfer->getSku(),
            ])
            ->withCustomer([CustomerTransfer::CUSTOMER_REFERENCE => $customerTransfer->getCustomerReference()])
            ->withTotals()
            ->withShippingAddress()
            ->withBillingAddress()
            ->withCurrency()
            ->withPayment()
            ->build();
    }

    protected function createProductConcrete(ProductConfigurationsApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();
        $I->havePriceProduct([
            PriceProductTransfer::SKU_PRODUCT_ABSTRACT => $this->productConcreteTransfer->getAbstractSku(),
            PriceProductTransfer::SKU_PRODUCT => $this->productConcreteTransfer->getSku(),
            PriceProductTransfer::MONEY_VALUE => [
                MoneyValueTransfer::NET_AMOUNT => 100,
                MoneyValueTransfer::GROSS_AMOUNT => 100,
            ],
        ]);
    }

    protected function createProductConfiguration(ProductConfigurationsApiTester $I): void
    {
        $this->productConfigurationTransfer = $I->haveProductConfigurationTransferPersisted([
            ProductConfigurationTransfer::FK_PRODUCT => $this->productConcreteTransfer->getIdProductConcrete(),
            ProductConfigurationTransfer::CONFIGURATOR_KEY => static::TEST_CONFIGURATOR_KEY,
            ProductConfigurationTransfer::DEFAULT_CONFIGURATION => static::TEST_CONFIGURATION,
            ProductConfigurationTransfer::DEFAULT_DISPLAY_DATA => static::TEST_DISPLAY_DATA,
        ]);
    }

    protected function createCustomerTransfer(ProductConfigurationsApiTester $I): void
    {
        $this->customerTransfer = $I->haveCustomer([
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        $I->confirmCustomer($this->customerTransfer);
    }

    protected function createOrder(ProductConfigurationsApiTester $I): void
    {
        $productConfigurationInstanceTransfer = $this->createProductConfigurationInstanceTransfer($this->productConfigurationTransfer);
        $quoteTransfer = $this->createQuoteTransfer(
            $this->customerTransfer,
            $this->productConcreteTransfer,
            $productConfigurationInstanceTransfer,
        );

        $this->saveOrderTransfer = $I->haveOrderFromQuote(
            $quoteTransfer,
            $this->createStateMachine($I),
        );

        $I->getLocator()
            ->salesProductConfiguration()
            ->facade()
            ->saveSalesOrderItemConfigurationsFromQuote($quoteTransfer);
    }

    protected function createStateMachine(ProductConfigurationsApiTester $I): string
    {
        $testStateMachineProcessName = 'DummyPayment01';
        $I->configureTestStateMachine([$testStateMachineProcessName]);

        return $testStateMachineProcessName;
    }

    protected function createProductConfigurationInstanceTransfer(
        ProductConfigurationTransfer $productConfigurationTransfer,
    ): ProductConfigurationInstanceTransfer {
        $productConfigurationInstanceTransfer = (new ProductConfigurationInstanceBuilder($productConfigurationTransfer->toArray()))
            ->withPrice()
            ->build()
            ->setIsComplete(true);

        if ($productConfigurationTransfer->getDefaultConfiguration()) {
            $productConfigurationInstanceTransfer->setConfiguration($productConfigurationTransfer->getDefaultConfiguration());
        }

        if ($productConfigurationTransfer->getDefaultDisplayData()) {
            $productConfigurationInstanceTransfer->setDisplayData($productConfigurationTransfer->getDefaultDisplayData());
        }

        return $productConfigurationInstanceTransfer;
    }
}
