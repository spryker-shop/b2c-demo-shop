<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model\ProductSet;

use Spryker\Zed\DataImport\Business\Model\DataImportStep\AddLocalesStep;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class ProductSetImageLocalizedAttributesExtractorStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    public const KEY_IMAGE_ALT_TEXT_LOCALIZED_ATTRIBUTES = 'imageAltTextLocalizedAttributes';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $imageAltTextLocalizedAttributes = [];
        foreach ($dataSet[AddLocalesStep::KEY_LOCALES] as $localeName => $idLocale) {
            $attributes = [];

            foreach ($dataSet[ProductSetImageExtractorStep::KEY_LOCALIZED_ATTRIBUTE_NAMES] as $attributeName) {
                if (!isset($dataSet[$attributeName . '.' . $localeName])) {
                    continue;
                }

                $attributes[$attributeName] = $dataSet[$attributeName . '.' . $localeName];
            }

            $imageAltTextLocalizedAttributes[$idLocale] = $attributes;
        }

        $dataSet[static::KEY_IMAGE_ALT_TEXT_LOCALIZED_ATTRIBUTES] = $imageAltTextLocalizedAttributes;
    }
}
