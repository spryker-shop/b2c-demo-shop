<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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
    protected const PYZ_PARAMETER_ID_PRODUCT_ABSTRACT = 'idProductAbstract';

    /**
     * @var string
     */
    protected const PYZ_PARAMETER_PRODUCT_REVIEW_STORAGE_TRANSFER = 'productReviewStorageTransfer';

    /**
     * @var string
     */
    protected const PYZ_PARAMETER_FORM = 'form';

    /**
     * @var string
     */
    protected const PYZ_PARAMETER_HIDE_FORM = 'hideForm';

    /**
     * @var string
     */
    protected const PYZ_PARAMETER_HAS_CUSTOMER = 'hasCustomer';

    /**
     * @var string
     */
    protected const PYZ_PARAMETER_PRODUCT_REVIEWS = 'productReviews';

    /**
     * @var string
     */
    protected const PYZ_PARAMETER_PAGINATION = 'pagination';

    /**
     * @var string
     */
    protected const PYZ_PARAMETER_SUMMARY = 'summary';

    /**
     * @var string
     */
    protected const PYZ_PARAMETER_MAXIMUM_RATING = 'maximumRating';

    /**
     * @param int $idProductAbstract
     */
    public function __construct(int $idProductAbstract)
    {
        $request = $this->getPyzCurrentRequest();
        $productReviews = $this->findPyzProductReviews($idProductAbstract, $request);

        $ratingAggregationTransfer = (new RatingAggregationTransfer());
        $ratingAggregationTransfer->setRatingAggregation($productReviews['ratingAggregation']);

        $this->addPyzHasCustomerParameter();
        $this->addPyzMaximumRatingParameter();
        $this->addPyzIdProductAbstractParameter($idProductAbstract);
        $this->addPyzProductReviewStorageTransferParameter($idProductAbstract);
        $this->addPyzFormParameter($idProductAbstract);
        $this->addPyzHideFormParameter($idProductAbstract);
        $this->addPyzProductReviewsParameter($idProductAbstract);
        $this->addPyzPaginationParameter($idProductAbstract);
        $this->addPyzSummaryParameter($idProductAbstract);
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'ProductDetailPageReviewWidget';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@ProductReviewWidget/views/pdp-review/pdp-review.twig';
    }

    /**
     * @param int $idProductAbstract
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getPyzProductReviewForm(int $idProductAbstract): FormInterface
    {
        $request = $this->getPyzCurrentRequest();

        return $this->getFactory()
            ->createPyzProductReviewForm($idProductAbstract)
            ->handleRequest($request);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function getPyzCurrentRequest(): Request
    {
        return $this->getPyzRequestStack()->getCurrentRequest();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RequestStack
     */
    protected function getPyzRequestStack(): RequestStack
    {
        return $this->getGlobalContainer()->get('request_stack');
    }

    /**
     * @param int $idProductAbstract
     * @param \Symfony\Component\HttpFoundation\Request $parentRequest
     *
     * @return array
     */
    protected function findPyzProductReviews(int $idProductAbstract, Request $parentRequest): array
    {
        $productReviewSearchRequestTransfer = new ProductReviewSearchRequestTransfer();
        $productReviewSearchRequestTransfer->setIdProductAbstract($idProductAbstract);
        $productReviewSearchRequestTransfer->setRequestParams($parentRequest->query->all());

        return $this->getFactory()
            ->getProductReviewClient()
            ->findProductReviewsInSearch($productReviewSearchRequestTransfer);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function addPyzIdProductAbstractParameter(int $idProductAbstract): void
    {
        $this->addParameter(static::PYZ_PARAMETER_ID_PRODUCT_ABSTRACT, $idProductAbstract);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function addPyzProductReviewStorageTransferParameter(int $idProductAbstract): void
    {
        $productReviewStorageTransfer = $this->getFactory()
            ->getProductReviewStorageClient()
            ->findProductAbstractReview($idProductAbstract);

        $this->addParameter(static::PYZ_PARAMETER_PRODUCT_REVIEW_STORAGE_TRANSFER, $productReviewStorageTransfer);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function addPyzFormParameter(int $idProductAbstract): void
    {
        $form = $this->getPyzProductReviewForm($idProductAbstract);

        $this->addParameter(static::PYZ_PARAMETER_FORM, $form->createView());
    }

    /**
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function addPyzHideFormParameter(int $idProductAbstract): void
    {
        $form = $this->getPyzProductReviewForm($idProductAbstract);

        $this->addParameter(static::PYZ_PARAMETER_HIDE_FORM, !$form->isSubmitted());
    }

    /**
     * @return void
     */
    protected function addPyzHasCustomerParameter(): void
    {
        $customer = $this->getFactory()->getCustomerClient()->getCustomer();

        $this->addParameter(static::PYZ_PARAMETER_HAS_CUSTOMER, $customer !== null);
    }

    /**
     * @return void
     */
    protected function addPyzMaximumRatingParameter(): void
    {
        $maximumRating = $this->getFactory()->getProductReviewClient()->getMaximumRating();

        $this->addParameter(static::PYZ_PARAMETER_MAXIMUM_RATING, $maximumRating);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function addPyzProductReviewsParameter(int $idProductAbstract): void
    {
        $request = $this->getPyzCurrentRequest();
        $productReviews = $this->findPyzProductReviews($idProductAbstract, $request);

        $this->addParameter(static::PYZ_PARAMETER_PRODUCT_REVIEWS, $productReviews[static::PYZ_PARAMETER_PRODUCT_REVIEWS]);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function addPyzPaginationParameter(int $idProductAbstract): void
    {
        $request = $this->getPyzCurrentRequest();
        $productReviews = $this->findPyzProductReviews($idProductAbstract, $request);

        $this->addParameter(static::PYZ_PARAMETER_PAGINATION, $productReviews[static::PYZ_PARAMETER_PAGINATION]);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return void
     */
    protected function addPyzSummaryParameter(int $idProductAbstract): void
    {
        $request = $this->getPyzCurrentRequest();
        $productReviews = $this->findPyzProductReviews($idProductAbstract, $request);

        $ratingAggregationTransfer = (new RatingAggregationTransfer());
        $ratingAggregationTransfer->setRatingAggregation($productReviews['ratingAggregation']);

        $this->addParameter(
            static::PYZ_PARAMETER_SUMMARY,
            $this->getFactory()
                ->getProductReviewClient()
                ->calculateProductReviewSummary($ratingAggregationTransfer),
        );
    }
}
