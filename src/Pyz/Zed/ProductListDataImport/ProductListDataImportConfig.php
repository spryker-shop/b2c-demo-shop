<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductListDataImport;

use Spryker\Zed\ProductListDataImport\ProductListDataImportConfig as SprykerProductListDataImportConfig;

class ProductListDataImportConfig extends SprykerProductListDataImportConfig
{
    /**
     * @return string
     */
    protected function getModuleRoot(): string
    {
        $moduleRoot = APPLICATION_ROOT_DIR;

        return $moduleRoot . DIRECTORY_SEPARATOR;
    }
}
