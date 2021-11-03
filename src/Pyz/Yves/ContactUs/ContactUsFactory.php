<?php
namespace Pyz\Yves\ContactUs;

use Pyz\Yves\ContactUs\Form\ContactUsForm;
use Pyz\Yves\ContactUs\Form\DataProvider\ContactUsFormDataProvider;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;
use Symfony\Component\Form\FormInterface;

class ContactUsFactory extends AbstractFactory
{

    /**
     * @return  \Pyz\Yves\ContactUs\Form\DataProvider\ContactUsFormDataProvider
     */
    public function createContactUsFormDataProvider(): ContactUsFormDataProvider
    {
        return new ContactUsFormDataProvider();
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormFactory(): \Symfony\Component\Form\FormFactory
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }


    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createContactUsForm(): FormInterface
    {
        $contactUsFormDataProvider = $this->createContactUsFormDataProvider();

        return $this->getFormFactory()->create(ContactUsForm::class, $contactUsFormDataProvider->getData());
    }

}
