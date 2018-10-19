<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Yves\ProductReviewWidget\Controller;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Shared\Storage\StorageConstants;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use SprykerShop\Yves\ProductReviewWidget\Controller\SubmitController as SprykerSubmitController;

/**
 * @method \SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetFactory getFactory()
 */
class SubmitController extends SprykerSubmitController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    protected function executeIndexAction(Request $request): array
    {
        $parentRequest = $this->getParentRequest();
        $idProductAbstract = $request->attributes->get('idProductAbstract');

        $customer = $this->getFactory()->getCustomerClient()->getCustomer();
        $productReviewForm = $this->getFactory()
            ->createProductReviewForm($idProductAbstract)
            ->handleRequest($parentRequest);
        $isFormEmpty = !$productReviewForm->isSubmitted();
        $isReviewPosted = $this->processProductReviewForm($productReviewForm, $customer);

        if ($isReviewPosted) {
            $productReviewForm = $this->getFactory()->createProductReviewForm($idProductAbstract);
            $this->addSuccessMessage('product_review.submit.success');
        }

        return [
            'hideForm' => $isFormEmpty || $isReviewPosted,
            'form' => $productReviewForm->createView(),
        ];
    }
}
