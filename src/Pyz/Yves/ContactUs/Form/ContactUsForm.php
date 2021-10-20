<?php

namespace Pyz\Yves\ContactUs\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactUsForm extends AbstractType
{
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'contactUsForm';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'label' => 'Name',
            'constraints' => [
                new NotBlank(),
            ],
        ])->add('message', TextType::class, [
            'label' => 'Message',
            'constraints' => [
                new NotBlank(),
            ],
        ]);
    }
}
