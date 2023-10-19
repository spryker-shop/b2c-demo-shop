<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CategoryDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\CategoryDataImport\Business\CategoryDataImportFacade as SprykerCategoryDataImportFacade;
use Spryker\Zed\CategoryDataImport\Business\CategoryDataImportFacadeInterface;

/**
 * @method \Pyz\Zed\CategoryDataImport\Business\CategoryDataImportBusinessFactory getFactory()
 */
class CategoryDataImportFacade extends SprykerCategoryDataImportFacade implements CategoryDataImportFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function import(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null): DataImporterReportTransfer
    {
        return $this->getFactory()->createCategoryImporter()->import($dataImporterConfigurationTransfer);
    }
}
