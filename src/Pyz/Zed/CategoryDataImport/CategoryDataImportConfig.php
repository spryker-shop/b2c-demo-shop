<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\CategoryDataImport;

use Spryker\Zed\CategoryDataImport\CategoryDataImportConfig as SprykerCategoryDataImportConfig;

class CategoryDataImportConfig extends SprykerCategoryDataImportConfig
{
    const IMPORT_TYPE_CATEGORY = 'category';

    /**
     * @return \Generated\Shared\Transfer\DataImporterConfigurationTransfer
     */
    public function getCategoryDataImporterConfiguration()
    {
        $moduleDataImportDirectory = APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR;

        return $this->buildImporterConfiguration($moduleDataImportDirectory . 'category.csv', static::IMPORT_TYPE_CATEGORY);
    }
}
