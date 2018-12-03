<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CategoryDataImport\Business;

use Pyz\Zed\CategoryDataImport\Business\Model\CategoryWriterStep;
use Spryker\Zed\CategoryDataImport\Business\CategoryDataImportBusinessFactory as SprykerCategoryDataImportBusinessFactory;

/**
 * @method \Spryker\Zed\CategoryDataImport\CategoryDataImportConfig getConfig()
 */
class CategoryDataImportBusinessFactory extends SprykerCategoryDataImportBusinessFactory
{
    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createCategoryImporter()
    {
        $dataImporter = $this->getCsvDataImporterFromConfig($this->getConfig()->getCategoryDataImporterConfiguration());

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createLocalizedAttributesExtractorStep([
                CategoryWriterStep::KEY_NAME,
                CategoryWriterStep::KEY_META_TITLE,
                CategoryWriterStep::KEY_META_DESCRIPTION,
                CategoryWriterStep::KEY_META_KEYWORDS,
                CategoryWriterStep::KEY_CATEGORY_IMAGE_NAME,
            ]))
            ->addStep(new CategoryWriterStep($this->createCategoryRepository()));

        $dataImporter
            ->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }
}
