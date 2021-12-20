<?php

namespace Pyz\Zed\Developer\Business;

use Generated\Shared\Transfer\DeveloperTransfer;

interface DeveloperFacadeInterface
{
    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer
     */
    public function createDeveloper(DeveloperTransfer $cookTransfer): DeveloperTransfer;

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer
     */
    public function saveDeveloper(DeveloperTransfer $cookTransfer): DeveloperTransfer;

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer|null
     */
    public function findDeveloper(DeveloperTransfer $cookTransfer): ?DeveloperTransfer;

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer[]
     */

    public function findDevelopers(DeveloperTransfer $cookTransfer): array;

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return void
     */

    public function deleteDeveloper(DeveloperTransfer $cookTransfer): void;

}
