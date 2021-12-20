<?php

namespace Pyz\Zed\Developer\Persistence;

use Generated\Shared\Transfer\DeveloperTransfer;

interface DeveloperRepositoryInterface
{
    /**
     * @param DeveloperTransfer $developerTransfer
     *
     * @return DeveloperTransfer|null
     */
    public function findDeveloperByTransfer(DeveloperTransfer $developerTransfer): ?DeveloperTransfer;


    /**
     * @param DeveloperTransfer $developerTransfer
     *
     * @return array
     */
    public function findDevelopersByTransfer(DeveloperTransfer $developerTransfer): array;

}
