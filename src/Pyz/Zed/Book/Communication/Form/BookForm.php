<?php

namespace Pyz\Zed\Book\Communication\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Pyz\Zed\Book\BookTransfer;

// class BookForm extends AbstractType
// {
//     public function buildForm(FormBuilderInterface $builder, array $options)
//     {
//       $builder
//             ->add('name', TextType::class, ['label' => 'Name'])
//             ->add('description', TextType::class, ['label' => 'Description'])
//             ->add('publicationDate', DateType::class, [
//                 'label' => 'Publication Date',
//                 'widget' => 'single_text',
//                 'html5' => true,
//                 'required' => true,
//             ])
//             ->add('save', SubmitType::class, ['label' => 'Save Book']);
//     }

//     public function configureOptions(OptionsResolver $resolver)
//     {
//         $resolver->setDefaults([
//             'data_class' => BookTransfer::class,
//         ]);
//     }
// }
class BookForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Book Name',
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
            ])
            ->add('publicationDate', DateType::class, [
                'label' => 'Publication Date',
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookTransfer::class,
        ]);
    }
}