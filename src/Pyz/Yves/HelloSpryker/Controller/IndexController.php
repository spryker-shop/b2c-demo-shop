<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\HelloSpryker\Controller;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Pyz\Yves\HelloSpryker\Plugin\Router\HelloSprykerRouteProviderPlugin;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\HelloSpryker\HelloSprykerFactory getFactory()
 * @method \Pyz\Client\HelloSpryker\HelloSprykerClient getClient()
 */
class IndexController extends AbstractController
{
    public const SUCCESS_MESSAGE = 'Message sent';
    public const FAIL_MESSAGE = 'Message not sent';
    public const REQUEST_HEADER_REFERER = 'referer';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(Request $request)
    {
        $contactUsForm = $this
            ->getFactory()
            ->createContactUsForm()
            ->handleRequest($request);

        if ($contactUsForm->isSubmitted()) {
            $this->handleContactUsForm($contactUsForm, $request);

            return $this->redirect($request);
        }

        $data = ['contactUsForm' => $contactUsForm->createView()];

        return $this->view(
            $data,
            [],
            '@HelloSpryker/views/index/index.twig'
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function redirect(Request $request)
    {
        if ($request->headers->has(static::REQUEST_HEADER_REFERER)) {
            return $this->redirectResponseExternal($request->headers->get(static::REQUEST_HEADER_REFERER));
        }

        return $this->redirectResponseInternal(HelloSprykerRouteProviderPlugin::ROUTE_NAME_HELLO_SPRYKER_INDEX);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $contactUsForm
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function handleContactUsForm(FormInterface $contactUsForm, Request $request)
    {
        if (!$contactUsForm->isValid()) {
            $this->addErrorMessage(self::FAIL_MESSAGE);
        } else {
            $contactUsTransfer = new PyzContactUsEntityTransfer();
            $contactUsTransfer->fromArray($contactUsForm->getData(), true);
            $this->getClient()
                ->saveContactUsData($contactUsTransfer);

            $this->addSuccessMessage(self::SUCCESS_MESSAGE);
        }
    }
}
