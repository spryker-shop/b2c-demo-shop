<?php

namespace Pyz\Zed\Faq\Communication\Controller;

use Pyz\Zed\Faq\Communication\FaqCommunicationFactory;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method FaqCommunicationFactory getFactory()
 */
class DebugController extends AbstractController {

    public function indexAction() {

        $locale = $this->getFactory()
            ->getLocaleFacade();

        var_dump($locale->getAvailableLocales()); die();
    }

    public function  tableAction(): JsonResponse {


    }
}
