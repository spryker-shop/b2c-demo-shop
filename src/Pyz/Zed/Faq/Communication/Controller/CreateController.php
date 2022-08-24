<?php

namespace Pyz\Zed\Faq\Communication\Controller;

use Pyz\Zed\Faq\Business\FaqFacade;
use Pyz\Zed\Faq\Communication\FaqCommunicationFactory;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method FaqCommunicationFactory getFactory()
 * @method FaqFacade getFacade()
 */
class CreateController extends AbstractController {

    public function indexAction(Request $request) {
        $faqForm = $this->getFactory()
            ->createFaqForm()
            ->handleRequest($request);

        if ($faqForm->isSubmitted() && $faqForm->isValid()) {

            $data = ($faqForm->getData());

            //$transfer = $this->getFacade()->createPlanetEntity($data);

            $this->addSuccessMessage('Faq was created successfully');
            return $this->redirectResponse('/faq/list');
        }

        return $this->viewResponse([
            'faqForm' => $faqForm->createView()
        ]);
    }
}
