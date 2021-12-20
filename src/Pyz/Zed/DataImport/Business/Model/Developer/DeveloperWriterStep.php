<?php

namespace Pyz\Zed\DataImport\Business\Model\Developer;


use Orm\Zed\Developer\Persistence\Map\PyzDeveloperTableMap;
use Orm\Zed\Developer\Persistence\PyzDeveloper;
use Pyz\Zed\DataImport\Business\Exception\InvalidDataException;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class DeveloperWriterStep implements DataImportStepInterface
{
    protected const KEY_NAME = 'name';
    protected const KEY_SURNAME = 'surname';
    protected const KEY_PROFESSION = 'profession';
    protected const KEY_STATUS = 'status';
    protected const KEY_DESCRIPTION = 'description';

    /**
     * @param DataSetInterface $dataSet
     *
     * @return void
     *@throws InvalidDataException
     *
     */
    public function execute(DataSetInterface $dataSet)
    {
        if (!$this->isProvidedStatusValid($dataSet)) {
            throw new InvalidDataException(
                sprintf("Provided status: '%s' isn't available for the Developer entity ", $dataSet[static::KEY_STATUS])
            );
        }

        $cookEntity = new PyzDeveloper();
        $cookEntity->setName($dataSet[static::KEY_NAME]);
        $cookEntity->setSurname($dataSet[static::KEY_SURNAME]);
        $cookEntity->setProfession($dataSet[static::KEY_PROFESSION]);
        $cookEntity->setStatus($dataSet[static::KEY_STATUS]);
        $cookEntity->setDescription($dataSet[static::KEY_DESCRIPTION]);

        $cookEntity->save();
    }

    /**
     * @param DataSetInterface $dataSet
     *
     * @return bool
     */
    protected function isProvidedStatusValid(DataSetInterface $dataSet): bool
    {
        $status = $dataSet[static::KEY_STATUS];

        return in_array($status, $this->getListAvailableStatuses());
    }

    /**
     * @return array
     */
    protected function getListAvailableStatuses(): array
    {
        return PyzDeveloperTableMap::getValueSets()[PyzDeveloperTableMap::COL_STATUS];
    }

}
