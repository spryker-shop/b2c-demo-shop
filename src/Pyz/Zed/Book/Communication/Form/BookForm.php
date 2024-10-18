<?php

namespace Pyz\Zed\Book\Communication\Form;

use Generated\Shared\Transfer\PyzBookTransfer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookForm extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options){
    $builder
        ->add('name', TextType::class, [
            'label' => 'Name',
            'constraints' => [new Assert\NotBlank(), new Assert\Length(['max' => 255])],
        ])
        ->add('description', TextareaType::class, [
            'label' => 'Description',
            'constraints' => [new Assert\NotBlank()],
        ])
        ->add('publication_date', DateTimeType::class, [
            'label' => 'Publication Date',
            'constraints' => [new Assert\NotBlank()],
        ])
        ->add('save', SubmitType::class, ['label' => 'Save']);
}




    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            'data_class' => PyzBookTransfer::class,
        ]);
    }
}
