<?php
namespace Pyz\Zed\Book\Communication\Form;

use Pyz\Zed\Book\Communication\Form\DataTransformer\DateTimeTransferToDateTimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Generated\Shared\Transfer\BookTransfer;
use Generated\Shared\Transfer\DateTimeTransfer;

class BookForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Book Name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter book name',
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter book description',
                    'rows' => 5
                ],
            ])
            ->add('publicationDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Publication Date',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Select publication date',
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Book',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
            ->get('publicationDate')
            ->addModelTransformer(new DateTimeTransferToDateTimeTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookTransfer::class,
        ]);
    }
}
