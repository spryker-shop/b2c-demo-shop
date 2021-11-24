<?php


namespace Pyz\Zed\ContactUs\Communication\Controller;


use Pyz\Zed\ContactUs\Communication\ContactUsCommunicationFactory;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * Class IndexController
 * @package Pyz\Zed\ContactUs\Communication\Controller
 *
 * @method ContactUsCommunicationFactory getFactory()
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

        return $this->viewResponse(
            [
                'contactUsTable' => $table->render(),
            ]
        );
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
