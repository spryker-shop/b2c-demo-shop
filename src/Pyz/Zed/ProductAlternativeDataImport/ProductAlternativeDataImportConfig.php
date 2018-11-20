<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ProductAlternativeDataImport;

use Spryker\Zed\ProductAlternativeDataImport\ProductAlternativeDataImportConfig as SprykerProductAlternativeDataImportConfig;

class ProductAlternativeDataImportConfig extends SprykerProductAlternativeDataImportConfig
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
