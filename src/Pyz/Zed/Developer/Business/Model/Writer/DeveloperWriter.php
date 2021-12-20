<?php

namespace Pyz\Zed\Developer\Business\Model\Writer;

use Generated\Shared\Transfer\DeveloperTransfer;
use Pyz\Zed\Developer\Persistence\DeveloperEntityManagerInterface;

class DeveloperWriter
{
    /**
     * @var DeveloperEntityManagerInterface
     */
    private $developerEntityManager;


    /**
     * @param DeveloperEntityManagerInterface $developerEntityManager
     */
    public function __construct(DeveloperEntityManagerInterface $developerEntityManager)
    {
        $this->developerEntityManager = $developerEntityManager;
    }


    /**
     * @param DeveloperTransfer $developerTransfer
     *
     * @return DeveloperTransfer
     */
    public function createDeveloper(DeveloperTransfer $developerTransfer): DeveloperTransfer
    {
        return $this->developerEntityManager->createDeveloper($developerTransfer);
    }


    /**
     * @param DeveloperTransfer $developerTransfer
     *
     * @return DeveloperTransfer
     */
    public function updateDeveloper(DeveloperTransfer $developerTransfer): DeveloperTransfer
    {
        $developerTransfer->requireIdDeveloper();

        return $this->developerEntityManager->updateDeveloper($developerTransfer);
    }

    /**
     * @param DeveloperTransfer $developerTransfer
     *
     * @return void
     */
    public function deleteDeveloper(DeveloperTransfer $developerTransfer): void
    {
        $developerTransfer->requireIdDeveloper();

        $this->developerEntityManager->deleteDeveloper($developerTransfer);
    }
}
