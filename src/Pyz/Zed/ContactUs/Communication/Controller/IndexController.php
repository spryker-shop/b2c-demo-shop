<?php

namespace Pyz\Zed\ContactUs\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;


/**
 * @method \Pyz\Zed\ContactUs\Business\ContactUsFacadeInterface getFacade()
 */
class IndexController extends AbstractController
{
    public function indexAction()
    {
        $contactUsData = $this->getFacade()->getContactUsData();

        return $this->viewResponse(['contactUsData' => $contactUsData]);
    }
}
