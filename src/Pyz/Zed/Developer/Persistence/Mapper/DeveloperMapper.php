<?php

namespace Pyz\Zed\Developer\Persistence\Mapper;

use Generated\Shared\Transfer\DeveloperTransfer;
use Orm\Zed\Developer\Persistence\PyzDeveloper;
use Propel\Runtime\Collection\ObjectCollection;

class DeveloperMapper
{
    /**
     * @param PyzDeveloper $pyzDeveloper
     * @param DeveloperTransfer $developerTransfer
     *
     * @return DeveloperTransfer
     */
    public function mapDeveloperEntityToTransfer(PyzDeveloper $pyzDeveloper, DeveloperTransfer $developerTransfer): DeveloperTransfer
    {
        return $developerTransfer->fromArray($pyzDeveloper->toArray(), true);
    }

    /**
     * @param DeveloperTransfer $developerTransfer
     * @param PyzDeveloper $pyzDeveloper
     *
     * @return PyzDeveloper
     */
    public function mapDeveloperTransferToEntity(DeveloperTransfer $developerTransfer, PyzDeveloper $pyzDeveloper): PyzDeveloper
    {
        return $pyzDeveloper->fromArray($developerTransfer->toArray());
    }


    /**
     * @param ObjectCollection $collection
     *
     * @return array
     */
    public function mapDeveloperEntityCollectionToTransfers(ObjectCollection $collection): array
    {
        $developerTransfers = [];

        foreach ($collection as $developerEntity) {
            $developerTransfers[] = $this->mapDeveloperEntityToTransfer($developerEntity, new DeveloperTransfer());
        }

        return $developerTransfers;

    }

}
