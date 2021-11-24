<?php

namespace Pyz\Yves\ContactUs\Controller;

use Pyz\Yves\ContactUs\ContactUsFactory;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 * @package Pyz\Yves\ContactUs\Controller
 *
 * @method ContactUsFactory getFactory()
 */
class IndexController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $contactUsForm = $this
            ->getFactory()
            ->createContactUsFormType()
            ->handleRequest($request);

        if ($contactUsForm->isSubmitted() && $contactUsForm->isValid()) {


            return $this->redirectResponseInternal('home');
        }

        return $this->view(
            [
                'contactUsForm' => $contactUsForm->createView(),
            ],
            [],
            '@ContactUs/views/index/index.twig'
        );
    }
}
