<?php

namespace Pyz\Zed\Developer\Persistence;

use Generated\Shared\Transfer\DeveloperTransfer;
use Orm\Zed\Developer\Persistence\PyzDeveloper;
use Propel\Runtime\Exception\EntityNotFoundException;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

class DeveloperEntityManager extends AbstractEntityManager implements DeveloperEntityManagerInterface
{
    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer
     */

    public function createDeveloper(DeveloperTransfer $cookTransfer): DeveloperTransfer
    {
        $pyzDeveloperEntity = $this->getFactory()->createDeveloperMapper()->mapDeveloperTransferToEntity($cookTransfer, new PyzDeveloper());
        $pyzDeveloperEntity->save();

        return $this->getFactory()->createDeveloperMapper()->mapDeveloperEntityToTransfer($pyzDeveloperEntity, $cookTransfer);
    }

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer
     *@throws EntityNotFoundException
     *
     */
    public function updateDeveloper(DeveloperTransfer $cookTransfer): DeveloperTransfer
    {

        $cookTransfer->requireIdDeveloper();
        $pyzDeveloperEntity = $this->getFactory()->createDeveloperQuery()->findOneByIdDeveloper($cookTransfer->getIdDeveloper());

        if (!$pyzDeveloperEntity) {
            throw new EntityNotFoundException(sprintf('Developer entity with id: %s haven\'t been found', $cookTransfer->getIdDeveloper()));
        }

        $pyzDeveloperEntity = $this->getFactory()->createDeveloperMapper()->mapDeveloperTransferToEntity($cookTransfer, $pyzDeveloperEntity);
        $pyzDeveloperEntity->save();

        return $this->getFactory()->createDeveloperMapper()->mapDeveloperEntityToTransfer($pyzDeveloperEntity, $cookTransfer);

    }

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return void
     */
    public function deleteDeveloper(DeveloperTransfer $cookTransfer): void
    {

        $cookTransfer->requireIdDeveloper();
        $pyzDeveloperEntity = $this->getFactory()->createDeveloperQuery()->findOneByIdDeveloper($cookTransfer->getIdDeveloper());

        if ($pyzDeveloperEntity) {
            $pyzDeveloperEntity->delete();
        }
    }

}
