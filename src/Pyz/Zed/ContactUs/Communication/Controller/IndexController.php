<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * Class IndexController
 *
 * @package Pyz\Zed\ContactUs\Communication\Controller
 *
 * @method \Pyz\Zed\ContactUs\Communication\ContactUsCommunicationFactory getFactory()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface getRepository()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\ContactUs\Business\ContactUsFacadeInterface getFacade()
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
