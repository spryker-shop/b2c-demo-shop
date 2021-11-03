<?php

namespace Pyz\Yves\ContactUs\Controller;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Client\ContactUs\ContactUsClientInterface getClient()
 */
class IndexController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $contactUsForm = $this
            ->getFactory()
            ->createContactUsForm()
            ->handleRequest($request);

        if ($contactUsForm->isSubmitted() && $contactUsForm->isValid()) {

            $formData = $contactUsForm->getData();
            $contactUsTransfer = new ContactUsTransfer();
            $contactUsTransfer->setName($formData['name']);
            $contactUsTransfer->setMessage($formData['message']);

            $contactUsResponseTransfer = ($this->getClient())->addMessage($contactUsTransfer);
            if ($contactUsResponseTransfer->getIsSuccess()) {
                $this->addSuccessMessage('The message was saved successfully!');
            } else {
                $this->addErrorMessage('Error saving the message!');
            }

            return $this->redirectResponseInternal('home');
        }

        return $this->view(
            ['contactUsForm' => $contactUsForm->createView()],
            [],
            '@ContactUs/views/index/index.twig'
        );
    }
}
