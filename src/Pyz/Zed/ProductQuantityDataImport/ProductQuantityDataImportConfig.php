<?php
/**
 * Created by PhpStorm.
 * User: kravchenko
 * Date: 2019-07-23
 * Time: 14:52
 */

namespace Pyz\Zed\ProductQuantityDataImport;

use Spryker\Zed\ProductQuantityDataImport\ProductQuantityDataImportConfig as SprykerProductQuantityDataImportConfig;


class ProductQuantityDataImportConfig extends SprykerProductQuantityDataImportConfig
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
