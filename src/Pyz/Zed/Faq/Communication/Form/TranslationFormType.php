<?php

namespace Pyz\Zed\Faq\Communication\Form;

use Generated\Shared\Transfer\FaqLocalizedTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslationFormType extends AbstractType {

    public function configureOptions(OptionsResolver $resolver) {

        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $this->addLocaleName($builder);
    }

    public function addLocaleName(FormBuilderInterface $builder) {
        $builder->add('storeRelation', HiddenType::class);
    }
}
