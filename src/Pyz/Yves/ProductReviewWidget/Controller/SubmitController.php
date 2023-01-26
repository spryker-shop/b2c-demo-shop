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
    protected const PYZ_PRODUCT_REVIEW_ERROR_PLEASE_LOGIN = 'product_review.error.please_login';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(Request $request): View
    {
        $viewData = $this->executePyzIndexAction($request);

        return $this->view($viewData, [], '@ProductReviewWidget/views/review-create/review-create.twig');
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function processPyzProductReviewForm(
        FormInterface $form,
        ?CustomerTransfer $customerTransfer = null,
    ): ?CustomerTransfer {
        if (!$form->isSubmitted()) {
            return null;
        }

        $result = $this->processPyzCoreProductReviewForm($form, $customerTransfer);

        if ($result) {
            $this->addSuccessMessage('product_review.submit.success');
        } else {
            $this->addErrorMessage('product_review.submit.error');
        }

        return $result;
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    protected function processPyzCoreProductReviewForm(
        FormInterface $form,
        ?CustomerTransfer $customerTransfer = null,
    ): ?CustomerTransfer {
        if (!$form->isSubmitted()) {
            return null;
        }

        $customerReference = $customerTransfer === null ? null : $customerTransfer->getCustomerReference();

        $this->getFactory()->getPyzGlossaryClient();

        if ($customerReference === null) {
            $glossaryStorageClient = $this->getFactory()->getPyzGlossaryClient();
            $errorMessage = $glossaryStorageClient->translate(self::PYZ_PRODUCT_REVIEW_ERROR_PLEASE_LOGIN, $this->getLocale());
            $form->addError(new FormError($errorMessage));
        }

        if (!$form->isValid()) {
            return null;
        }

        $productReviewResponseTransfer = $this->getFactory()->getProductReviewClient()->submitCustomerReview(
            $this->getPyzProductReviewFormData($form)
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
    protected function getPyzProductReviewFormData(FormInterface $form): ProductReviewRequestTransfer
    {
        return $form->getData();
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executePyzIndexAction(Request $request): array
    {
        $parentRequest = $this->getRequestStack()->getParentRequest();
        $idProductAbstract = $request->attributes->get('idProductAbstract');

        $customer = $this->getFactory()->getCustomerClient()->getCustomer();
        $productReviewForm = $this->getFactory()
            ->createPyzProductReviewForm($idProductAbstract)
            ->handleRequest($parentRequest);
        $isFormEmpty = !$productReviewForm->isSubmitted();
        $isReviewPosted = $this->processPyzProductReviewForm($productReviewForm, $customer);

        if ($isReviewPosted) {
            $productReviewForm = $this->getFactory()->createPyzProductReviewForm($idProductAbstract);
        }

        return [
            'hideForm' => $isFormEmpty || $isReviewPosted,
            'form' => $productReviewForm->createView(),
            'showSuccess' => $isReviewPosted,
        ];
    }
}
