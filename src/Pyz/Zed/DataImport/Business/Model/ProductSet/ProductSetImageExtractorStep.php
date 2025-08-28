<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model\ProductSet;

use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class ProductSetImageExtractorStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    public const KEY_TARGET = 'productImageSets';

    /**
     * @var string
     */
    public const IMAGE_SET_KEY_PREFIX = 'image_set.';

    /**
     * @var string
     */
    public const IMAGE_SMALL_KEY_PREFIX = 'image_small.';

    /**
     * @var string
     */
    public const IMAGE_LARGE_KEY_PREFIX = 'image_large.';

    /**
     * @var string
     */
    public const KEY_LOCALIZED_ATTRIBUTE_NAMES = 'localized_attribute_names';

    /**
     * @var string
     */
    public const IMAGE_ALT_TEXT_KEY_PREFIX = 'alt_text.';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $imageSets = [];
        $localizedAttributeNames = [];

        foreach ($dataSet as $key => $value) {
            if (!preg_match('/' . static::IMAGE_SET_KEY_PREFIX . '(\d+)/', $key, $match)) {
                continue;
            }

            $imageSets[$match[1]] = [
                'image_set' => $value,
                'images' => [],
            ];
        }
        foreach ($dataSet as $key => $value) {
            if (preg_match('/^' . static::IMAGE_SMALL_KEY_PREFIX . '(\d+).(\d+)/', $key, $match)) {
                $imageSets[$match[1]]['images'][$match[2]]['image_small'] = $value;
                $localizedAttributeNames[] = static::IMAGE_ALT_TEXT_KEY_PREFIX . static::IMAGE_SMALL_KEY_PREFIX . $match[1] . '.' . $match[2];
            }
            if (!preg_match('/^' . static::IMAGE_LARGE_KEY_PREFIX . '(\d+).(\d+)/', $key, $match)) {
                continue;
            }

            $imageSets[$match[1]]['images'][$match[2]]['image_large'] = $value;
            $localizedAttributeNames[] = static::IMAGE_ALT_TEXT_KEY_PREFIX . static::IMAGE_LARGE_KEY_PREFIX . $match[1] . '.' . $match[2];
        }

        $dataSet[static::KEY_LOCALIZED_ATTRIBUTE_NAMES] = $localizedAttributeNames;
        $dataSet[static::KEY_TARGET] = $imageSets;
    }
}
