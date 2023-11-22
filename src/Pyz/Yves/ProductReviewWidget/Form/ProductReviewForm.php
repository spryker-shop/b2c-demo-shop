<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductReviewWidget\Form;

use Generated\Shared\Transfer\ProductReviewRequestTransfer;
use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

/**
 * @method \SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetFactory getFactory()
 * @method \Pyz\Yves\ProductReviewWidget\ProductReviewWidgetConfig getConfig()
 */
class ProductReviewForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_RATING = ProductReviewRequestTransfer::RATING;

    /**
     * @var string
     */
    public const FIELD_SUMMARY = ProductReviewRequestTransfer::SUMMARY;

    /**
     * @var string
     */
    public const FIELD_DESCRIPTION = ProductReviewRequestTransfer::DESCRIPTION;

    /**
     * @var string
     */
    public const FIELD_NICKNAME = ProductReviewRequestTransfer::NICKNAME;

    /**
     * @var string
     */
    public const FIELD_PRODUCT = ProductReviewRequestTransfer::ID_PRODUCT_ABSTRACT;

    /**
     * @var int
     */
    public const UNSELECTED_RATING = -1;

    /**
     * @var int
     */
    public const MINIMUM_RATING = 1;

    /**
     * @deprecated Use {@link ProductReviewWidgetConfig::GLOSSARY_KEY_INVALID_RATING_VALIDATION_MESSAGE} instead.
     *
     * @var string
     */
    protected const VALIDATION_RATING_MESSAGE = 'validation.choice';

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'productReviewForm';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
            ->addSummaryField($builder)
            ->addRatingField($builder)
            ->addDescriptionField($builder)
            ->addNicknameField($builder)
            ->addProductField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addRatingField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_RATING,
            ChoiceType::class,
            [
                'choices' => array_flip($this->getRatingFieldChoices()),
                'label' => 'product_review.submit.rating',
                'required' => true,
                'expanded' => false,
                'multiple' => false,
                'constraints' => [
                    new GreaterThanOrEqual(
                        [
                        'value' => static::MINIMUM_RATING,
                        'message' => $this->getConfig()->getInvalidRatingValidationMessageGlossaryKey(),
                        ],
                    ),
                    new LessThanOrEqual(['value' => $this->getFactory()->getProductReviewClient()->getMaximumRating()]),
                ],
            ],
        );

        return $this;
    }

    /**
     * Returns a sequence between predefined minimum and maximum as an array with a leading "unselected" element
     * - keys match values
     *
     * @see ProductReviewForm::MINIMUM_RATING
     * @see ProductReviewClientInterface::getMaximumRating()
     *
     * Example
     *  [-1 => 'none', 1 => 1, 2 => 2]
     * @see ProductReviewForm::UNSELECTED_RATING
     *
     * @return array<mixed>
     */
    protected function getRatingFieldChoices(): array
    {
        $unselectedChoice = [static::UNSELECTED_RATING => 'product_review.submit.rating.none'];
        $choices = range(static::MINIMUM_RATING, $this->getFactory()->getProductReviewClient()->getMaximumRating());
        $choices = array_merge($unselectedChoice, array_combine($choices, $choices));

        return $choices;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addSummaryField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_SUMMARY,
            TextType::class,
            [
                'label' => 'product_review.submit.summary',
                'required' => false,
                'constraints' => [
                    new Length(['min' => 1]),
                ],
            ],
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDescriptionField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_DESCRIPTION,
            TextareaType::class,
            [
                'label' => 'product_review.submit.description',
                'attr' => [
                    'rows' => 5,
                ],
                'required' => false,
                'constraints' => [
                    new Length(['min' => 1]),
                ],
            ],
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNicknameField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_NICKNAME,
            TextType::class,
            [
                'label' => 'product_review.submit.nickname',
                'required' => false,
                'constraints' => [
                    new Length(['min' => 1, 'max' => 255]),
                ],
            ],
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addProductField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_PRODUCT,
            HiddenType::class,
            [
                'required' => true,
            ],
        );

        return $this;
    }
}
