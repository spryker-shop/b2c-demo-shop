<?php

namespace Pyz\Yves\ContactUs\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;

/**
 * @method \Pyz\Yves\ContactUs\ContactUsFactory getFactory()
 */
class IndexController extends AbstractController
{
    public function indexAction()
    {
        $contactUsForm = $this
            ->getFactory()
            ->createContactUsForm();

        return $this->view(
            [
                'contactUsForm' => $contactUsForm->createView(),
                'test' => 'test'
            ],
            [],
            '@ContactUs/views/index/index.twig'
        );
    }
}
