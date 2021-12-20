<?php

namespace Pyz\Zed\Developer\Business;

use Generated\Shared\Transfer\DeveloperTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

class DeveloperFacade extends AbstractFacade implements DeveloperFacadeInterface
{
    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer
     */
    public function createDeveloper(DeveloperTransfer $cookTransfer): DeveloperTransfer
    {
        return $this->getFactory()->createDeveloperWriter()->createDeveloper($cookTransfer);
    }

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer
     */
    public function saveDeveloper(DeveloperTransfer $cookTransfer): DeveloperTransfer
    {
        return $this->getFactory()->createDeveloperWriter()->updateDeveloper($cookTransfer);
    }

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer|null
     */
    public function findDeveloper(DeveloperTransfer $cookTransfer): ?DeveloperTransfer
    {
        return $this->getFactory()->createDeveloperReader()->findDeveloperByTransfer($cookTransfer);
    }

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer[]
     */
    public function findDevelopers(DeveloperTransfer $cookTransfer): array
    {
        return $this->getFactory()->createDeveloperReader()->findDevelopersByTransfer($cookTransfer);
    }

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return void
     */
    public function deleteDeveloper(DeveloperTransfer $cookTransfer): void
    {
        $this->getFactory()->createDeveloperWriter()->deleteDeveloper($cookTransfer);
    }

}
