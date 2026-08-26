<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Yves\ProductReviewWidget\Widget;

use Generated\Shared\Transfer\ProductReviewSearchRequestTransfer;
use Generated\Shared\Transfer\RatingAggregationTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @method \Pyz\Yves\ProductReviewWidget\ProductReviewWidgetFactory getFactory()
 */
class ProductDetailPageReviewWidget extends AbstractWidget
{
    /**
     * @var string
     */
    protected const PARAMETER_ID_PRODUCT_ABSTRACT = 'idProductAbstract';

    /**
     * @var string
     */
    protected const PARAMETER_PRODUCT_REVIEW_STORAGE_TRANSFER = 'productReviewStorageTransfer';

    /**
     * @var string
     */
    protected const PARAMETER_FORM = 'form';

    /**
     * @var string
     */
    protected const PARAMETER_HIDE_FORM = 'hideForm';

    /**
     * @var string
     */
    protected const PARAMETER_HAS_CUSTOMER = 'hasCustomer';

    /**
     * @var string
     */
    protected const PARAMETER_PRODUCT_REVIEWS = 'productReviews';

    /**
     * @var string
     */
    protected const PARAMETER_PAGINATION = 'pagination';

    /**
     * @var string
     */
    protected const PARAMETER_SUMMARY = 'summary';

    /**
     * @var string
     */
    protected const PARAMETER_MAXIMUM_RATING = 'maximumRating';

    public function __construct(int $idProductAbstract)
    {
        $request = $this->getCurrentRequest();
        $productReviews = $this->findProductReviews($idProductAbstract, $request);

        $ratingAggregationTransfer = (new RatingAggregationTransfer());
        $ratingAggregationTransfer->setRatingAggregation($productReviews['ratingAggregation']);

        $this->addHasCustomerParameter();
        $this->addMaximumRatingParameter();
        $this->addIdProductAbstractParameter($idProductAbstract);
        $this->addProductReviewStorageTransferParameter($idProductAbstract);
        $this->addFormParameter($idProductAbstract);
        $this->addHideFormParameter($idProductAbstract);
        $this->addProductReviewsParameter($idProductAbstract);
        $this->addPaginationParameter($idProductAbstract);
        $this->addSummaryParameter($idProductAbstract);
    }

    public static function getName(): string
    {
        return 'ProductDetailPageReviewWidget';
    }

    public static function getTemplate(): string
    {
        return '@ProductReviewWidget/views/pdp-review/pdp-review.twig';
    }

    protected function getProductReviewForm(int $idProductAbstract): FormInterface
    {
        $request = $this->getCurrentRequest();

        return $this->getFactory()
            ->createProductReviewForm($idProductAbstract)
            ->handleRequest($request);
    }

    protected function getCurrentRequest(): Request
    {
        return $this->getRequestStack()->getCurrentRequest();
    }

    protected function getRequestStack(): RequestStack
    {
        return $this->getGlobalContainer()->get('request_stack');
    }

    /**
     * @return array<mixed>
     */
    protected function findProductReviews(int $idProductAbstract, Request $parentRequest): array
    {
        $productReviewSearchRequestTransfer = new ProductReviewSearchRequestTransfer();
        $productReviewSearchRequestTransfer->setIdProductAbstract($idProductAbstract);
        $productReviewSearchRequestTransfer->setRequestParams($parentRequest->query->all());

        return $this->getFactory()
            ->getProductReviewClient()
            ->findProductReviewsInSearch($productReviewSearchRequestTransfer);
    }

    protected function addIdProductAbstractParameter(int $idProductAbstract): void
    {
        $this->addParameter(static::PARAMETER_ID_PRODUCT_ABSTRACT, $idProductAbstract);
    }

    protected function addProductReviewStorageTransferParameter(int $idProductAbstract): void
    {
        $productReviewStorageTransfer = $this->getFactory()
            ->getProductReviewStorageClient()
            ->findProductAbstractReview($idProductAbstract);

        $this->addParameter(static::PARAMETER_PRODUCT_REVIEW_STORAGE_TRANSFER, $productReviewStorageTransfer);
    }

    protected function addFormParameter(int $idProductAbstract): void
    {
        $form = $this->getProductReviewForm($idProductAbstract);

        $this->addParameter(static::PARAMETER_FORM, $form->createView());
    }

    protected function addHideFormParameter(int $idProductAbstract): void
    {
        $form = $this->getProductReviewForm($idProductAbstract);

        $this->addParameter(static::PARAMETER_HIDE_FORM, !$form->isSubmitted());
    }

    protected function addHasCustomerParameter(): void
    {
        $customer = $this->getFactory()->getCustomerClient()->getCustomer();

        $this->addParameter(static::PARAMETER_HAS_CUSTOMER, $customer !== null);
    }

    protected function addMaximumRatingParameter(): void
    {
        $maximumRating = $this->getFactory()->getProductReviewClient()->getMaximumRating();

        $this->addParameter(static::PARAMETER_MAXIMUM_RATING, $maximumRating);
    }

    protected function addProductReviewsParameter(int $idProductAbstract): void
    {
        $request = $this->getCurrentRequest();
        $productReviews = $this->findProductReviews($idProductAbstract, $request);

        $this->addParameter(static::PARAMETER_PRODUCT_REVIEWS, $productReviews[static::PARAMETER_PRODUCT_REVIEWS]);
    }

    protected function addPaginationParameter(int $idProductAbstract): void
    {
        $request = $this->getCurrentRequest();
        $productReviews = $this->findProductReviews($idProductAbstract, $request);

        $this->addParameter(static::PARAMETER_PAGINATION, $productReviews[static::PARAMETER_PAGINATION]);
    }

    protected function addSummaryParameter(int $idProductAbstract): void
    {
        $request = $this->getCurrentRequest();
        $productReviews = $this->findProductReviews($idProductAbstract, $request);

        $ratingAggregationTransfer = (new RatingAggregationTransfer());
        $ratingAggregationTransfer->setRatingAggregation($productReviews['ratingAggregation']);

        $this->addParameter(
            static::PARAMETER_SUMMARY,
            $this->getFactory()
                ->getProductReviewClient()
                ->calculateProductReviewSummary($ratingAggregationTransfer),
        );
    }
}
