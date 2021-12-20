<?php

namespace Pyz\Zed\DeveloperGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexController extends AbstractController
{

    /**
     * @return array
     */

    public function indexAction(): array
    {
        $developerTable = $this
            ->getFactory()
            ->createDeveloperTable();

        return $this->viewResponse([
            'developerTable' => $developerTable->render(),
        ]);
    }


    /**
     * @return JsonResponse
     */
    public function tableAction(): JsonResponse
    {
        $developerTable = $this
            ->getFactory()
            ->createDeveloperTable();

        return $this->jsonResponse(

            $developerTable->fetchData()

        );

    }

}
