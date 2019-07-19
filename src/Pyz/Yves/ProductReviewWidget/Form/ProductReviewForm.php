<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductReviewWidget\Form;

use SprykerShop\Yves\ProductReviewWidget\Form\ProductReviewForm as SprykerShopProductReviewForm;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

/**
 * @method \SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetFactory getFactory()
 */
class ProductReviewForm extends SprykerShopProductReviewForm
{
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'productReviewForm';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addSummaryField($builder)
            ->addRatingField($builder)
            ->addDescriptionField($builder)
            ->addNicknameField($builder)
            ->addProductField($builder);

        return $this;
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
                    new GreaterThanOrEqual(['value' => static::MINIMUM_RATING]),
                    new LessThanOrEqual(['value' => $this->getFactory()->getProductReviewClient()->getMaximumRating()]),
                ],
            ]
        );

        return $this;
    }

    /**
     * Returns a sequence between predefined minimum and maximum as an array with a leading "unselected" element
     * - keys match values
     *
     * @see ProductReviewForm::UNSELECTED_RATING
     * @see ProductReviewForm::MINIMUM_RATING
     * @see ProductReviewClientInterface::getMaximumRating()
     *
     * Example
     *  [-1 => 'none', 1 => 1, 2 => 2]
     *
     * @return array
     */
    protected function getRatingFieldChoices()
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
            ]
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
            ]
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
            ]
        );

        return $this;
    }
}
