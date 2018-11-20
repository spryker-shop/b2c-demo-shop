<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductDataImport;

use Spryker\Zed\PriceProductDataImport\PriceProductDataImportConfig as SprykerPriceProductDataImportConfig;

class PriceProductDataImportConfig extends SprykerPriceProductDataImportConfig
{
    /**
     * @return string
     */
    protected function getModuleRoot(): string
    {
        $moduleRoot = realpath(APPLICATION_ROOT_DIR);

        return $moduleRoot . DIRECTORY_SEPARATOR;
    }
}
