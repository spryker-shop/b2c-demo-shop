<?php

namespace Pyz\Zed\ContactUs\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \Pyz\Zed\ContactUs\Business\ContactUsFacade getFacade()
 */
class IndexController extends AbstractController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $contactUsEntities = $this->getFacade()->getContactUsData();

        return $this->viewResponse([
            'contactUsEntities' => $contactUsEntities,
        ]);
    }

}
