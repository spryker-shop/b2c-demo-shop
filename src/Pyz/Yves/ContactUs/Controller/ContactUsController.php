<?php

namespace Pyz\Yves\ContactUs\Controller;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\ContactUs\ContactUsFactory getFactory()
 * @method \Pyz\Client\ContactUs\ContactUsClientInterface getClient()
 */
class ContactUsController extends AbstractController
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $subscriptionForm = $this
            ->getFactory()
            ->createContactUsForm()
            ->handleRequest($request);

        if ($subscriptionForm->isSubmitted() && $subscriptionForm->isValid()) {
            $formData = $request->request->all();
            $contactUsTransfer = new ContactUsTransfer();
            $contactUsTransfer->setName($formData['contact_us_form']['name']);
            $contactUsTransfer->setMessage($formData['contact_us_form']['message']);
            $contactUsTransfer = $this->getClient()->saveContact($contactUsTransfer);

            // Redirect to home page after successful subscription
            return $this->redirectResponseInternal('home');
        }
        if ($request->getMethod() === 'POST'){

        }
        $contactUsForm = $this
            ->getFactory()
            ->createContactUsForm();
        $data = ['contactUsForm' => $contactUsForm->createView()];

        return $this->view(
            $data,
            [],
            '@ContactUs/views/index/index.twig'
        );
    }

}
