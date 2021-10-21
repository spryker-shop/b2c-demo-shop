<?php

namespace Pyz\Yves\ContactUs\Controller;

use Generated\Shared\Transfer\ContactUsTransfer;
use Pyz\Client\ContactUs\ContactUsClientInterface;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\ContactUs\ContactUsFactory getFactory()
 * @method ContactUsClientInterface getClient()
 */
class IndexController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $contactUsForm = $this
            ->getFactory()
            ->createContactUsForm()
            ->handleRequest($request);

        if ($contactUsForm->isSubmitted() && $contactUsForm->isValid()) {
            $contactUsTransfer = new ContactUsTransfer();
            $contactUsTransfer->setName($request->request->get('contactUsForm')['name']);
            $contactUsTransfer->setMessage($request->request->get('contactUsForm')['message']);

            try {
                $this->getClient()->saveContactUs($contactUsTransfer);
            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }

            return $this->redirectResponseInternal('home');
        }

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
