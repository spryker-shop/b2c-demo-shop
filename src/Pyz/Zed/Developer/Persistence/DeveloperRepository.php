<?php

namespace Pyz\Zed\Developer\Persistence;

use Generated\Shared\Transfer\DeveloperTransfer;
use Orm\Zed\Developer\Persistence\PyzDeveloperQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

class DeveloperRepository extends AbstractRepository implements DeveloperRepositoryInterface
{

    /**
     * @param DeveloperTransfer $developerTransfer
     *
     * @return DeveloperTransfer|null
     */

    public function findDeveloperByTransfer(DeveloperTransfer $developerTransfer): ?DeveloperTransfer
    {
        $developerQuery = $this->createQueryByDeveloperTransfer($developerTransfer);

        $pyzDeveloperEntity = $developerQuery->findOne();

        if (!$pyzDeveloperEntity) {
            return null;
        }

        return $this->getFactory()->createDeveloperMapper()->mapDeveloperEntityToTransfer($pyzDeveloperEntity, new DeveloperTransfer());
    }


    /**
     * @param DeveloperTransfer $developerTransfer
     *
     * @return array
     */
    public function findDevelopersByTransfer(DeveloperTransfer $developerTransfer): array
    {
        $developerQuery = $this->createQueryByDeveloperTransfer($developerTransfer);

        $pyzDeveloperEntities = $developerQuery->find();

        return $this->getFactory()->createDeveloperMapper()->mapDeveloperEntityCollectionToTransfers($pyzDeveloperEntities);
    }

    /**
     * @param DeveloperTransfer $developerTransfer
     *
     * @return PyzDeveloperQuery
     */
    protected function createQueryByDeveloperTransfer(DeveloperTransfer $developerTransfer): PyzDeveloperQuery
    {

        $developerQuery = $this->getFactory()->createDeveloperQuery();

        if ($developerTransfer->getIdDeveloper()) {
            $developerQuery->filterByIdDeveloper($developerTransfer->getIdDeveloper());
        }

        if ($developerTransfer->getStatus()) {
            $developerQuery->filterByStatus($developerTransfer->getStatus());
        }

        if ($developerTransfer->getName()) {
            $developerQuery->filterByName_Like($developerTransfer->getName());
        }

        return $developerQuery;

    }

}
