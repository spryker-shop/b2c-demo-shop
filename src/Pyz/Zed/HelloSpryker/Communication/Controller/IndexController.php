<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 *
 * @package Pyz\Zed\UserHelloWorld\Communication\Controller
 * @method \Pyz\Zed\HelloSpryker\Business\HelloSprykerFacade getFacade()
 * @method \Pyz\Zed\HelloSpryker\Communication\HelloSprykerCommunicationFactory getFactory()
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerRepositoryInterface getRepository()
 */
class IndexController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $contactUsData = $this->getFacade()->getContactUsData();

        return ['contactUsData' => $contactUsData];
    }
}
