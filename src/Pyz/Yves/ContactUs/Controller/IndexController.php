<?php

namespace Pyz\Yves\ContactUs\Controller;

use Generated\Shared\Transfer\ContactUsTransfer;
use Pyz\Client\ContactUs\ContactUsClientInterface;
use Pyz\Yves\ContactUs\ContactUsFactory;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 * @package Pyz\Yves\ContactUs\Controller
 *
 * @method ContactUsFactory getFactory()
 * @method ContactUsClientInterface getClient()
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
            $this->getClient()->addContactUsFeedback((new ContactUsTransfer())->fromArray($contactUsForm->getData()));

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
