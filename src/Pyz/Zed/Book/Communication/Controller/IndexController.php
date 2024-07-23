<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \Pyz\Zed\Book\Business\BookFacadeInterface getFacade()
 * @method \Pyz\Zed\Book\Persistence\BookQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Book\Communication\BookCommunicationFactory getFactory()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class IndexController extends AbstractController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $locales = $this->getFactory()->getEnabledLocales();
        $table = $this->getFactory()->createBookTable($locales);

        return $this->viewResponse([
            'bookTable' => $table->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction()
    {
        $locales = $this->getFactory()->getEnabledLocales();
        $table = $this->getFactory()->createBookTable($locales);

        return $this->jsonResponse($table->fetchData());
    }
}
