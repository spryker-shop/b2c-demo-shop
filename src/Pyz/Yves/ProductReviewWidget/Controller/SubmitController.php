<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductReviewWidget\Controller;

use Generated\Shared\Transfer\CustomerTransfer;
use SprykerShop\Yves\ProductReviewWidget\Controller\SubmitController as SprykerSubmitController;
use Symfony\Component\Form\FormInterface;

/**
 * @method \SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetFactory getFactory()
 */
class SubmitController extends SprykerSubmitController
{
    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param \Generated\Shared\Transfer\CustomerTransfer|null $customer
     *
     * @return bool Returns true if the review was posted
     */
    protected function processProductReviewForm(FormInterface $form, ?CustomerTransfer $customer = null)
    {
        if (!$form->isSubmitted()) {
            return false;
        }

        $result = parent::processProductReviewForm($form, $customer);

        if ($result) {
            $this->addSuccessMessage('product_review.submit.success');
        } else {
            $this->addErrorMessage('product_review.submit.error');
        }

        return $result;
    }
}
