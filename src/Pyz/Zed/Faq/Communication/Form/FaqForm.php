<?php

namespace Pyz\Zed\Faq\Communication\Form;

use Generated\Shared\Transfer\FaqTransfer;
use Generated\Shared\Transfer\PlanetTransfer;
use PHPStan\Type\BooleanType;
use Pyz\Zed\Planet\Communication\Form\PlanetForm;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class FaqForm extends AbstractType {

    private const FIELD_QUESTION = 'question';
    private const FIELD_ANSWER = 'answer';
    private const FIELD_ENABLED = 'enabled';
    private const BUTTON_SUBMIT = 'Submit';

    public function getBlockPrefix(): string {
        return 'faq';
    }

    public function configureOptions(OptionsResolver $resolver) {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_class' => FaqTransfer::class
        ]);
    }


    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void {

        $this
            ->addQuestionField($builder)
            ->addAnswerField($builder)
            ->addEnabledField($builder)
            ->addSubmitButton($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */

    private function addQuestionField(FormBuilderInterface $builder): FaqForm
    {
        $builder->add(static::FIELD_QUESTION, TextareaType::class, [
            'constraints' => [
                new NotBlank(),
            ]
        ]);
        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    private function addAnswerField(FormBuilderInterface $builder): FaqForm
    {
        $builder->add(static::FIELD_ANSWER, TextType::class, [
            'constraints' => [
                new NotBlank(),
            ]
        ]);
        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    private function addEnabledField(FormBuilderInterface $builder): FaqForm
    {
        $builder->add(static::FIELD_ENABLED, CheckboxType::class, [
            'label' => 'Is enabled?',
            'constraints' => [
                new NotBlank()
            ]
        ]);
        return $this;
    }

    private function addSubmitButton(FormBuilderInterface $builder): FaqForm {
        $builder->add(static::BUTTON_SUBMIT, SubmitType::class);
        return $this;
    }
}
