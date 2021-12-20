<?php

namespace Pyz\Zed\DeveloperGui\Communication\Form;

use Orm\Zed\Developer\Persistence\Map\PyzDeveloperTableMap;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeveloperFormEdit extends AbstractType
{
    public const FIELD_NAME = 'name';
    public const FIELD_SURNAME = 'surname';
    public const FIELD_PROFESSION = 'profession';
    public const FIELD_STATUS = 'status';
    public const FIELD_DESCRIPTION = 'description';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return FormBuilderInterface
     */
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $builder = $this->addNameField($builder, $options);
        $builder = $this->addSurnameField($builder, $options);
        $builder = $this->addProfessionField($builder, $options);
        $builder = $this->addStatusField($builder, $options);
        $builder = $this->addDescriptionField($builder, $options);

        return $builder;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return FormBuilderInterface
     */
    protected function addSurnameField(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $builder->add(static::FIELD_SURNAME, TextType::class, [
            'label' => 'Surname',
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $builder;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return FormBuilderInterface
     */
    protected function addDescriptionField(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $builder->add(static::FIELD_DESCRIPTION, TextareaType::class, [
            'label' => 'Description',
            'required' => false,
            'attr' => [
                'class' => 'html-editor',
                'max' => '6500',
            ],
            'constraints' => [
                new Length(['max' => 6500]),
            ],
        ]);

        return $builder;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return FormBuilderInterface
     */
    protected function addNameField(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $builder->add(static::FIELD_NAME, TextType::class, [
            'label' => 'Name',
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $builder;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return FormBuilderInterface
     */
    protected function addProfessionField(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $builder->add(static::FIELD_PROFESSION, TextType::class, [
            'label' => 'Profession',
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $builder;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return FormBuilderInterface
     */
    protected function addStatusField(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $builder->add(static::FIELD_STATUS, ChoiceType::class, [
            'label' => 'Status',
            'required' => true,
            'empty_data' => PyzDeveloperTableMap::COL_STATUS_ACTIVE,
            'choices' => [
                'Active' => PyzDeveloperTableMap::COL_STATUS_ACTIVE,
                'Inactive' => PyzDeveloperTableMap::COL_STATUS_INACTIVE,
            ],
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $builder;
    }

}
