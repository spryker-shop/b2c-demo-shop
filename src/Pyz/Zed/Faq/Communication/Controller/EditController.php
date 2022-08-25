<?php

namespace Pyz\Zed\Faq\Communication\Controller;

use Pyz\Zed\Faq\Business\FaqFacade;
use Pyz\Zed\Faq\Communication\FaqCommunicationFactory;
use Pyz\Zed\Faq\Persistence\FaqRepository;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method FaqCommunicationFactory getFactory()
 * @method FaqFacade getFacade()
 */
class EditController extends AbstractController {

    public function indexAction(Request $req) {

        try {
            $id = $this->castId($req->query->get('id-faq'));
        }
        catch(\Exception $e) {
            $this->addErrorMessage('Cannot edit faq. Wrong id given.');
            return $this->redirectResponse('/faq/list');
        }


        $trans = $this->getFacade()->findFaqEntityById($id);

        if($trans === null) {
            $this->addErrorMessage('Faq with id = '.$id.' not found!');
            return $this->redirectResponse('/faq/list');
        }

        $form = $this->getFactory()
            ->createFaqForm($trans)
            ->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()) {

            //var_dump($form->getData()); die();

            $this->getFacade()
                ->updateFaqEntity(
                    $form->getData()
                );

            $this->addSuccessMessage('Faq updated successfully.');
            return $this->redirectResponse('/faq/list');
        }

        return [
          'faqForm' => $form->createView(),
        ];
    }
}
