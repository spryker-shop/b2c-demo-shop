<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\PriceProductVolumes\RestApi\Fixtures;

use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use PyzTest\Glue\PriceProductVolumes\PriceProductVolumesApiTester;
use Spryker\Shared\PriceProductVolume\PriceProductVolumeConfig;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class PriceProductVolumesRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var array
     */
    public const VOLUME_PRICE_DATA = [
        [
            PriceProductVolumeConfig::VOLUME_PRICE_QUANTITY => 5,
            PriceProductVolumeConfig::VOLUME_PRICE_NET_PRICE => 600,
            PriceProductVolumeConfig::VOLUME_PRICE_GROSS_PRICE => 666,
        ],
        [
            PriceProductVolumeConfig::VOLUME_PRICE_QUANTITY => 10,
            PriceProductVolumeConfig::VOLUME_PRICE_NET_PRICE => 500,
            PriceProductVolumeConfig::VOLUME_PRICE_GROSS_PRICE => 555,
        ],
        [
            PriceProductVolumeConfig::VOLUME_PRICE_QUANTITY => 15,
            PriceProductVolumeConfig::VOLUME_PRICE_NET_PRICE => 400,
            PriceProductVolumeConfig::VOLUME_PRICE_GROSS_PRICE => 444,
        ],
    ];

    /**
     * @var string
     */
    public const VOLUME_PRICE_ATTRIBUTE_JSON_PATH = '.prices[0].volumePrices';

    /**
     * @var \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    protected ProductConcreteTransfer $productConcreteTransfer;

    /**
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer
     */
    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    /**
     * @param \PyzTest\Glue\PriceProductVolumes\PriceProductVolumesApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(PriceProductVolumesApiTester $I): FixturesContainerInterface
    {
        $this->createProductConcrete($I);
        $this->createPriceProduct($I);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\PriceProductVolumes\PriceProductVolumesApiTester $I
     *
     * @return void
     */
    protected function createProductConcrete(PriceProductVolumesApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();
    }

    /**
     * @param \PyzTest\Glue\PriceProductVolumes\PriceProductVolumesApiTester $I
     *
     * @return void
     */
    protected function createPriceProduct(PriceProductVolumesApiTester $I): void
    {
        $I->havePriceProduct([
            PriceProductTransfer::SKU_PRODUCT_ABSTRACT => $this->productConcreteTransfer->getAbstractSku(),
            PriceProductTransfer::MONEY_VALUE => [
                MoneyValueTransfer::PRICE_DATA => $this->createVolumePriceData(),
            ],
        ]);
    }

    /**
     * @return string
     */
    protected function createVolumePriceData(): string
    {
        return json_encode([
            PriceProductVolumeConfig::VOLUME_PRICE_TYPE => static::VOLUME_PRICE_DATA,
        ]);
    }
}
