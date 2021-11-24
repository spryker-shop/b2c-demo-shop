<?php

namespace Pyz\Yves\ContactUs;

use Pyz\Yves\ContactUs\Form\ContactUsFormType;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;
use Symfony\Component\Form\FormInterface;

class ContactUsFactory extends AbstractFactory
{
    public function createContactUsFormType(): FormInterface
    {
        return $this->getFormFactory()->create(ContactUsFormType::class);
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormFactory()
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }
}
