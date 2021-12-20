<?php

namespace Pyz\Zed\DeveloperGui\Communication\Form;

use Generated\Shared\Transfer\DeveloperTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class DeveloperFormDelete extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return FormBuilderInterface
     */
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $builder = $this->addIdDeveloperField($builder);

        return $builder;
    }

    /**
     * @param FormBuilderInterface $builder
     *
     * @return FormBuilderInterface
     */
    protected function addIdDeveloperField(FormBuilderInterface $builder): FormBuilderInterface
    {
        $builder->add(
            DeveloperTransfer::ID_DEVELOPER,
            HiddenType::class,
            [
                'constraints' => [
                    new NotBlank(),
                ],
            ]
        );

        return $builder;
    }

}
