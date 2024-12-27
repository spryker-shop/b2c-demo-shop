<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\PriceProductVolumes;

use Generated\Shared\Transfer\RestProductPriceVolumesAttributesTransfer;
use Spryker\Shared\PriceProductVolume\PriceProductVolumeConfig;
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
 * @SuppressWarnings(\PyzTest\Glue\PriceProductVolumes\PHPMD)
 */
class PriceProductVolumesApiTester extends ApiEndToEndTester
{
    use _generated\PriceProductVolumesApiTesterActions;

    /**
     * @param array $expectedVolumePrices
     *
     * @return void
     */
    public function seeVolumePricesEqualToExpectedValue(array $expectedVolumePrices): void
    {
        $expectedVolumePrices = $this->mapVolumePricesDataToExpectedFormat($expectedVolumePrices);

        $this->assertEqualsCanonicalizing($expectedVolumePrices, $this->grabPriceProductVolumesData());
    }

    /**
     * @return array
     */
    protected function grabPriceProductVolumesData(): array
    {
        return $this->getDataFromResponseByJsonPath('$.data[0].attributes.prices[0].volumePrices');
    }

    /**
     * @param array $volumePrices
     *
     * @return array
     */
    protected function mapVolumePricesDataToExpectedFormat(array $volumePrices): array
    {
        return array_map(function (array $volumePrice): array {
            return (new RestProductPriceVolumesAttributesTransfer())
                ->fromArray($volumePrice, true)
                ->setNetAmount($volumePrice[PriceProductVolumeConfig::VOLUME_PRICE_NET_PRICE])
                ->setGrossAmount($volumePrice[PriceProductVolumeConfig::VOLUME_PRICE_GROSS_PRICE])
                ->toArray();
        }, $volumePrices);
    }
}
