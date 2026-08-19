<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\DataImport\Business\Model;

use Generated\Shared\Transfer\DataImporterReportTransfer;
use Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface;
use Spryker\Zed\DataImport\Business\Model\DataImporter;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class DataImporterConditional extends DataImporter
{
    /**
     * @var \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    protected $dataSetCondition;

    public function setDataSetCondition(DataSetConditionInterface $dataSetCondition): void
    {
        $this->dataSetCondition = $dataSetCondition;
    }

    protected function processDataSet(DataSetInterface $dataSet, DataImporterReportTransfer $dataImporterReportTransfer): void
    {
        if ($this->dataSetCondition->hasData($dataSet)) {
            parent::processDataSet($dataSet, $dataImporterReportTransfer);
        } else {
            $dataImporterReportTransfer->setExpectedImportableDataSetCount($dataImporterReportTransfer->getExpectedImportableDataSetCount() - 1);
        }
    }
}
