<?php

namespace Pyz\Zed\Faq\Communication\Controller;

use Pyz\Zed\Faq\Communication\FaqCommunicationFactory;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method FaqCommunicationFactory getFactory()
 */
class ListController extends AbstractController {

    public function indexAction() {

        return [
            'faqTable' => $this->getFactory()->createFaqTable()->render()
        ];
    }

    public function  tableAction(): JsonResponse {

        $faqTable = $this->getFactory()->createFaqTable();

        return $this->jsonResponse($faqTable->fetchData());
    }
}
