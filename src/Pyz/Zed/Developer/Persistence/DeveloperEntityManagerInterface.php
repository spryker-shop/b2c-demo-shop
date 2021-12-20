<?php

namespace Pyz\Zed\Developer\Persistence;

use Generated\Shared\Transfer\DeveloperTransfer;

interface DeveloperEntityManagerInterface
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
    public function updateDeveloper(DeveloperTransfer $cookTransfer): DeveloperTransfer;

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return void
     */
    public function deleteDeveloper(DeveloperTransfer $cookTransfer): void;
}
