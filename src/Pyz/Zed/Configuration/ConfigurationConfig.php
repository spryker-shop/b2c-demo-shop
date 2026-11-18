<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\Configuration;

use Generated\Shared\Transfer\DataImporterDataSourceConfigurationTransfer;
use Spryker\Zed\Configuration\ConfigurationConfig as SprykerConfigurationConfig;

class ConfigurationConfig extends SprykerConfigurationConfig
{
    /**
     * Specification:
     * - Returns the data importer data source configuration for configuration value import.
     * - Used by `DataImportFactoryTrait::getCsvDataImporterFromConfig()` to create the CSV reader.
     *
     * @api
     */
    public function getConfigurationValueDataImporterDataSourceConfiguration(): DataImporterDataSourceConfigurationTransfer
    {
        return (new DataImporterDataSourceConfigurationTransfer())
            ->setImportType(static::IMPORT_TYPE_CONFIGURATION_VALUE)
            ->setModuleName('configuration')
            ->setFileName('configuration_value.csv');
    }
}
