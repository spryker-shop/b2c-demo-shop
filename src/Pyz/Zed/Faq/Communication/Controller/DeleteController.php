<?php

namespace Pyz\Zed\Faq\Communication\Controller;

use Pyz\Zed\Faq\Business\FaqFacade;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method FaqFacade getFacade()
 */
class DeleteController extends AbstractController {

    public function indexAction(Request $req) {

        try {
            $id = $this->castId(
                $req->query->get('id-faq')
            );
        }
        catch(\Exception $e) {
            $this->addErrorMessage('Invalid id');
            return $this->redirectResponse('/faq/list');
        }

        $ent = $this->getFacade()->findFaqEntityById($id);

        if($ent === null) {
            $this->addErrorMessage('Faq with given id does not exist');
            return $this->redirectResponse('/faq/list');
        }

        $this->getFacade()
            ->deleteFaqEntity($ent);

        $this->addSuccessMessage('Faq entry deleted successfully');
        return $this->redirectResponse('/faq/list');
    }
}
