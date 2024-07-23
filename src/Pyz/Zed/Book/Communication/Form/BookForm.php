<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Communication\Form;

use Generated\Shared\Transfer\PyzBookEntityTransfer as PyzBookEntityTransferAlias;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @method \Pyz\Zed\Book\Business\BookFacadeInterface getFacade()
 * @method \Pyz\Zed\Book\Communication\BookCommunicationFactory getFactory()
 * @method \Pyz\Zed\Book\Persistence\BookQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Book\BookConfig getConfig()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class BookForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_NAME = 'name';

    /**
     * @var string
     */
    public const FIELD_DESCRIPTION = 'description';

    /**
     * @var string
     */
    public const FIELD_PUBLICATION_DATE = 'publication_date';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
            ->addNameField($builder)
            ->addDescriptionField($builder)
            ->addPublicationDateField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_NAME, TextType::class, [
            'label' => 'Name',
            'constraints' => [
                new NotBlank(),
                new Length(['max' => 255]),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addDescriptionField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_DESCRIPTION, TextareaType::class, [
            'label' => 'Description',
            'required' => false,
            'attr' => [
                'rows' => 10,
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addPublicationDateField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PUBLICATION_DATE, DateTimeType::class, [
            'label' => 'Publication Date',
            'widget' => 'single_text',
            'required' => false,
            'input' => 'datetime'
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PyzBookEntityTransferAlias::class,
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'book';
    }

    /**
     * @return string
     * @deprecated Use {@link getBlockPrefix()} instead.
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
