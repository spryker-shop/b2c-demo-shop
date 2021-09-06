<?php

namespace Pyz\Yves\ContactUs;

use Pyz\Yves\ContactUs\Form\ContactUsFormType;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;
use Symfony\Component\Form\FormFactory;

class ContactUsFactory extends AbstractFactory
{

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createContactUsForm()
    {
        return $this->getFormFactory()->create(ContactUsFormType::class);
    }

    /**
     * @return FormFactory
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getFormFactory(): FormFactory
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

}
