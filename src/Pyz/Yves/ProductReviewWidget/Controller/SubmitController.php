<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductReviewWidget\Controller;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ProductReviewRequestTransfer;
use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\ProductReviewWidget\Controller\SubmitController as SprykerSubmitController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\ProductReviewWidget\ProductReviewWidgetFactory getFactory()
 */
class SubmitController extends SprykerSubmitController
{
    /**
     * @var string
     */
    protected const PRODUCT_REVIEW_ERROR_PLEASE_LOGIN = 'product_review.error.please_login';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(Request $request): View
    {
        $viewData = $this->executeIndexAction($request);

        return $this->view($viewData, [], '@ProductReviewWidget/views/review-create/review-create.twig');
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customerTransfer
     *
     * @return bool
     */
    protected function processProductReviewForm(
        FormInterface $form,
        ?CustomerTransfer $customerTransfer = null,
    ): bool {
        if (!$form->isSubmitted()) {
            return false;
        }

        $result = $this->processCoreProductReviewForm($form, $customerTransfer);

        if ($result) {
            $this->addSuccessMessage('product_review.submit.success');
        } else {
            $this->addErrorMessage('product_review.submit.error');
        }

        return (bool)$result;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function processCoreProductReviewForm(
        FormInterface $form,
        ?CustomerTransfer $customerTransfer = null,
    ): ?CustomerTransfer {
        if (!$form->isSubmitted()) {
            return null;
        }

        $customerReference = $customerTransfer === null ? null : $customerTransfer->getCustomerReference();

        $this->getFactory()->getGlossaryClient();

        if ($customerReference === null) {
            $glossaryStorageClient = $this->getFactory()->getGlossaryClient();
            $errorMessage = $glossaryStorageClient->translate(self::PRODUCT_REVIEW_ERROR_PLEASE_LOGIN, $this->getLocale());
            $form->addError(new FormError($errorMessage));
        }

        if (!$form->isValid()) {
            return null;
        }

        $productReviewResponseTransfer = $this->getFactory()->getProductReviewClient()->submitCustomerReview(
            $this->getProductReviewFormData($form)
                ->setCustomerReference($customerReference)
                ->setLocaleName($this->getLocale()),
        );

        if ($productReviewResponseTransfer->getIsSuccess()) {
            return null;
        }

        $errorMessage = $productReviewResponseTransfer->getErrors()->getIterator()->current()->getMessage();
        $form->addError(new FormError($errorMessage));

        return null;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return \Generated\Shared\Transfer\ProductReviewRequestTransfer
     */
    protected function getProductReviewFormData(FormInterface $form): ProductReviewRequestTransfer
    {
        return $form->getData();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array<mixed>
     */
    protected function executeIndexAction(Request $request): array
    {
        $parentRequest = $this->getRequestStack()->getParentRequest();
        $idProductAbstract = $request->attributes->get('idProductAbstract');

        $customer = $this->getFactory()->getCustomerClient()->getCustomer();
        $productReviewForm = $this->getFactory()
            ->createProductReviewForm($idProductAbstract)
            ->handleRequest($parentRequest);
        $isFormEmpty = !$productReviewForm->isSubmitted();
        $isReviewPosted = $this->processProductReviewForm($productReviewForm, $customer);

        if ($isReviewPosted) {
            $productReviewForm = $this->getFactory()->createProductReviewForm($idProductAbstract);
        }

        return [
            'hideForm' => $isFormEmpty || $isReviewPosted,
            'form' => $productReviewForm->createView(),
            'showSuccess' => $isReviewPosted,
        ];
    }
}
