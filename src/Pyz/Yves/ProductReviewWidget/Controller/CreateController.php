<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductReviewWidget\Controller;

use SprykerShop\Yves\ProductReviewWidget\Controller\CreateController as SprykerCreateController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\ProductReviewWidget\ProductReviewWidgetFactory getFactory()
 */
class CreateController extends SprykerCreateController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request): RedirectResponse
    {
        $this->executeIndexAction($request);

        return $this->redirectResponseExternal($this->getRefererUrl($request));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string
     */
    protected function getRefererUrl(Request $request): string
    {
        if ($request->headers->has(static::REQUEST_HEADER_REFERER)) {
            return $request->headers->get(static::REQUEST_HEADER_REFERER);
        }

        return static::URL_MAIN;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function executeIndexAction(Request $request): void
    {
        $idProductAbstract = $request->attributes->get('idProductAbstract');
        $productReviewForm = $this->getFactory()
            ->createProductReviewForm($idProductAbstract)
            ->handleRequest($request);

        if (!$productReviewForm->isSubmitted()) {
            return;
        }

        $customerTransfer = $this->getFactory()->getCustomerClient()->getCustomer();

        if ($customerTransfer === null) {
            $this->addErrorMessage(static::GLOSSARY_KEY_ERROR_NO_CUSTOMER);

            return;
        }

        if (!$productReviewForm->isValid()) {
            foreach ($productReviewForm->getErrors(true) as $error) {
                $this->addErrorMessage($error->getMessage());
            }

            return;
        }

        $productReviewRequestTransfer = $productReviewForm->getData()
            ->setCustomerReference($customerTransfer->getCustomerReference())
            ->setLocaleName($this->getLocale());

        $productReviewResponseTransfer = $this->getFactory()
            ->getProductReviewClient()
            ->submitCustomerReview($productReviewRequestTransfer);

        if ($productReviewResponseTransfer->getIsSuccess() === false) {
            $this->addErrorMessage($productReviewResponseTransfer->getErrors()[0]->getMessage());

            return;
        }

        $this->addSuccessMessage(static::GLOSSARY_KEY_SUCCESS_PRODUCT_REVIEW_SUBMITTED);
    }
}
