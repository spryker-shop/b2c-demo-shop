<?php

namespace Pyz\Client\ContactUs;


use Pyz\Client\ContactUs\Zed\ContactUsZedStub;
use Pyz\Client\ContactUs\Zed\ContactUsZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class ContactUsFactory extends AbstractFactory
{
    public function createContactUsZedStub(): ContactUsZedStubInterface
    {
        return new ContactUsZedStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(ContactUsDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
