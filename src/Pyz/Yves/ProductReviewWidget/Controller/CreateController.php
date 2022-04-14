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
     * @var string
     */
    protected const PYZ_REQUEST_HEADER_REFERER = 'referer';

    /**
     * @var string
     */
    protected const PYZ_URL_MAIN = '/';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request): RedirectResponse
    {
        $this->executePyzIndexAction($request);

        return $this->redirectResponseExternal($this->getPyzRefererUrl($request));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string
     */
    protected function getPyzRefererUrl(Request $request): string
    {
        if ($request->headers->has(static::PYZ_REQUEST_HEADER_REFERER)) {
            return $request->headers->get(static::PYZ_REQUEST_HEADER_REFERER);
        }

        return static::PYZ_URL_MAIN;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    protected function executePyzIndexAction(Request $request): void
    {
        $idProductAbstract = $request->attributes->get('idProductAbstract');
        $productReviewForm = $this->getFactory()
            ->createPyzProductReviewForm($idProductAbstract)
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
