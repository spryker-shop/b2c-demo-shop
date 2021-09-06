<?php

namespace Pyz\Zed\ContactUs\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \Pyz\Zed\ContactUs\Business\ContactUsFacade getFacade()
 * @method \Pyz\Zed\ContactUs\Communication\ContactUsCommunicationFactory getFactory()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface getQueryContainer()
 */
class IndexController extends AbstractController
{

    /**
     * @return array
     */
    public function indexAction()
    {
        $table = $this->getFactory()
            ->createContactUsTable();

        return $this->viewResponse([
            'contactUsTable' => $table->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction()
    {
        $table = $this->getFactory()
            ->createContactUsTable();

        return $this->jsonResponse($table->fetchData());
    }

}
