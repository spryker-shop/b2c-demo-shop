<?php

namespace Pyz\Yves\ContactUs;

use Pyz\Yves\ContactUs\Form\ContactUsForm;
use Spryker\Yves\Kernel\AbstractFactory;

class ContactUsFactory extends AbstractFactory
{
    /**
     * @uses \Spryker\Yves\Form\Plugin\Application\FormApplicationPlugin::SERVICE_FORM_FACTORY
     */
    protected const SERVICE_FORM_FACTORY = 'form.factory';

    /**
     * @return \Symfony\Component\Form\FormInterface
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createContactUsForm()
    {
        return $this->getProvidedDependency(self::SERVICE_FORM_FACTORY)->create(ContactUsForm::class);
    }
}
