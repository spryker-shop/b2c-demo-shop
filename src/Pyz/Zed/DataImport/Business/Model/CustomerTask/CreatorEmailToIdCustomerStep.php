<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\CustomerTask;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CreatorEmailToIdCustomerStep implements DataImportStepInterface
{
    /**
     * @var array
     */
    private array $customerIds = [];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $this->validateMandatoryFields($dataSet);

        if (array_key_exists($dataSet[CustomerTaskWriterStep::KEY_CREATOR_EMAIL], $this->customerIds)) {
            $dataSet[CustomerTaskWriterStep::KEY_FK_CREATOR] = $this->customerIds[$dataSet[CustomerTaskWriterStep::KEY_CREATOR_EMAIL]];

            return;
        }

        $this->customerIds[$dataSet[CustomerTaskWriterStep::KEY_CREATOR_EMAIL]] = $this->getFkCreator($dataSet);
        $dataSet[CustomerTaskWriterStep::KEY_FK_CREATOR] = $this->customerIds[$dataSet[CustomerTaskWriterStep::KEY_CREATOR_EMAIL]];
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Spryker\Zed\DataImport\Business\Exception\DataKeyNotFoundInDataSetException
     *
     * @return void
     */
    private function validateMandatoryFields(DataSetInterface $dataSet): void
    {
        if (!isset($dataSet[CustomerTaskWriterStep::KEY_CREATOR_EMAIL])) {
            throw new DataKeyNotFoundInDataSetException(sprintf(
                'Expected a key "%s" in current data set. Available keys: "%s"',
                CustomerTaskWriterStep::KEY_CREATOR_EMAIL,
                implode(', ', array_keys($dataSet->getArrayCopy())),
            ));
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return int
     */
    private function getFkCreator(DataSetInterface $dataSet): int
    {
        $customerEntity = SpyCustomerQuery::create()
            ->filterByEmail($dataSet[CustomerTaskWriterStep::KEY_CREATOR_EMAIL])
            ->findOne();

        if (!$customerEntity) {
            if (!isset($dataSet[CustomerTaskWriterStep::KEY_CREATOR_EMAIL])) {
                throw new EntityNotFoundException(sprintf(
                    'Customer with username "%s" not found.',
                    $dataSet[CustomerTaskWriterStep::KEY_CREATOR_EMAIL],
                ));
            }
        }

        return $customerEntity->getIdCustomer();
    }
}
