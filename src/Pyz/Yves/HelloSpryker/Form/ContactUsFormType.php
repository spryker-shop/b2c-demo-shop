<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\HelloSpryker\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactUsFormType extends AbstractType
{
    public const FIELD_CUSTOMER_NAME_ID = 'name';
    public const FIELD_CUSTOMER_NAME_LABEL = 'Your name';
    public const FIELD_CUSTOMER_MESSAGE_ID = 'message';
    public const FIELD_CUSTOMER_MESSAGE_LABEL = 'Enter your message';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addCustomerNameField($builder)
            ->addCustomerMessage($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCustomerNameField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_CUSTOMER_NAME_ID, TextType::class, [
            'label' => self::FIELD_CUSTOMER_NAME_LABEL,
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addCustomerMessage(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_CUSTOMER_MESSAGE_ID, TextType::class, [
            'label' => self::FIELD_CUSTOMER_MESSAGE_LABEL,
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }
}
