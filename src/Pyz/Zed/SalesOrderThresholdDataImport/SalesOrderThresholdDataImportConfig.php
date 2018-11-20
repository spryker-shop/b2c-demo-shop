<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\SalesOrderThresholdDataImport;

use Spryker\Zed\SalesOrderThresholdDataImport\SalesOrderThresholdDataImportConfig as SprykerSalesOrderThresholdDataImportConfig;

class SalesOrderThresholdDataImportConfig extends SprykerSalesOrderThresholdDataImportConfig
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
