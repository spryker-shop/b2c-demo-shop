<?php

namespace Pyz\Zed\Faq\Communication\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Generated\Shared\Transfer\FaqLocalizedTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use PHPStan\Type\BooleanType;
use Pyz\Zed\Faq\FaqDependencyProvider;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Spryker\Zed\Locale\Business\LocaleFacade;
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

    private const LIST_FAQ_LOCALIZED = 'faq_localized';

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
            ->addStoreRelations($builder)
            ->addSubmitButton($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */

    private function addQuestionField(FormBuilderInterface $builder): FaqForm
    {
        $builder->add(static::FIELD_QUESTION, TextType::class, [
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
        $builder->add(static::FIELD_ANSWER, TextareaType::class, [
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
            'required' => false,
        ]);
        return $this;
    }

    private function addStoreRelations(FormBuilderInterface $builder): FaqForm {

        // TODO injectable
        $locales = (new LocaleFacade())->getAvailableLocales();

        foreach ($locales as $locale) {
            $builder->add('translations', TranslationFormType::class,
             []);
        }

        return $this;
    }

    private function addSubmitButton(FormBuilderInterface $builder): FaqForm {
        $builder->add(static::BUTTON_SUBMIT, SubmitType::class);
        return $this;
    }
}
