<?php

namespace Pyz\Zed\DeveloperGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\DeveloperTransfer;
use Pyz\Zed\Developer\Business\DeveloperFacadeInterface;

class DeveloperEditFormDataProvider
{
    /**
     * @var DeveloperFacadeInterface
     */
    private $cookFacade;

    /**
     * @param DeveloperFacadeInterface $cookFacade
     */
    public function __construct(DeveloperFacadeInterface $cookFacade)
    {
        $this->cookFacade = $cookFacade;
    }

    /**
     * @param int $idDeveloper
     *
     * @return array
     */
    public function getData(int $idDeveloper): array
    {
        $searchDeveloperTransfer = (new DeveloperTransfer())
            ->setIdDeveloper($idDeveloper);

        $cookTransfer = $this->cookFacade->findDeveloper($searchDeveloperTransfer);

        if (!$cookTransfer) {
            return [];
        }

        $data = $cookTransfer->toArray();

        return $data;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return [];
    }

}
