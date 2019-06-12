<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\PriceProductScheduleDataImport;

use Spryker\Zed\PriceProductScheduleDataImport\PriceProductScheduleDataImportConfig as SprykerPriceProductScheduleDataImportConfig;

class PriceProductScheduleDataImportConfig extends SprykerPriceProductScheduleDataImportConfig
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
