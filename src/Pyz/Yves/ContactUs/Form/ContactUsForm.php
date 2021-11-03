<?php
namespace Pyz\Yves\ContactUs\Form;

//use Symfony\Component\Form\AbstractType;
//use Spryker\Yves\Kernel\Form\AbstractType;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class ContactUsForm extends AbstractType
{

//    /**
//     * @return string
//     */
//    public function getTemplatePath(): string
//    {
//        return '@ContactUs' . '/views/' . 'index/index.twig';
//    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'ContactUsForm';
    }


    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addNameField($builder)
            ->addMessageField($builder);
    }


    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNameField(FormBuilderInterface $builder): ContactUsForm
    {
        $builder->add('name', TextType::class, [
            'required' => true,
            'label' => 'Name',
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 1, 'max' => 255]),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMessageField(FormBuilderInterface $builder): ContactUsForm
    {
        $builder->add('message', TextareaType::class, [
            'required' => true,
            'label' => 'Message',
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 1, 'max' => 500]),
            ],
        ]);

        return $this;
    }

//    /**
//     * User this method if you need to provide custom template path or additional data to template
//     *
//     * @param \Symfony\Component\Form\FormView $view
//     * @param \Symfony\Component\Form\FormInterface $form
//     * @param array $options
//     *
//     * @return void
//     */
//    public function buildView(FormView $view, FormInterface $form, array $options): void
//    {
//        $view->vars['attr']['template_path'] = '@ContactUs/views/index/index.twig';
//    }
}
