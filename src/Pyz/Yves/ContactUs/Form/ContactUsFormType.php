<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ContactUs\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactUsFormType extends AbstractType
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, [
            'label' => 'Email',
            'constraints' => [
                new NotBlank(),
                new Email(),
            ],
        ]);
        $builder->add('fullName', TextType::class, [
            'label' => 'Full Name',
            'constraints' => [
                new NotBlank(),
            ],
        ]);
        $builder->add('message', TextareaType::class, [
            'label' => 'Message',
            'constraints' => [
                new NotBlank(),
            ],
        ]);
    }
}
