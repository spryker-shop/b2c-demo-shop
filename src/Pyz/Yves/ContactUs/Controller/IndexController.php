<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContactUs\Controller;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class IndexController
 *
 * @package Pyz\Yves\ContactUs\Controller
 *
 * @method \Pyz\Yves\ContactUs\ContactUsFactory getFactory()
 * @method \Pyz\Client\ContactUs\ContactUsClientInterface getClient()
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
