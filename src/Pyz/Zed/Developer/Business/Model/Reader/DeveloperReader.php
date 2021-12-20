<?php

namespace Pyz\Zed\Developer\Business\Model\Reader;

use Generated\Shared\Transfer\DeveloperTransfer;
use Pyz\Zed\Developer\Persistence\DeveloperRepositoryInterface;

class DeveloperReader
{
    /**
     * @var DeveloperRepositoryInterface
     */
    private $cookRepository;

    /**
     * @param DeveloperRepositoryInterface $cookRepository
     */

    public function __construct(DeveloperRepositoryInterface $cookRepository)
    {
        $this->cookRepository = $cookRepository;
    }

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return DeveloperTransfer|null
     */
    public function findDeveloperByTransfer(DeveloperTransfer $cookTransfer): ?DeveloperTransfer
    {
        return $this->cookRepository->findDeveloperByTransfer($cookTransfer);
    }

    /**
     * @param DeveloperTransfer $cookTransfer
     *
     * @return array
     */

    public function findDevelopersByTransfer(DeveloperTransfer $cookTransfer): array
    {
        return $this->cookRepository->findDevelopersByTransfer($cookTransfer);
    }
}
