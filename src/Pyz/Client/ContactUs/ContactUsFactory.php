<?php

namespace Pyz\Client\ContactUs;

use Pyz\Client\ContactUs\Zed\ContactUsStub;
use Pyz\Client\ContactUs\Zed\ContactUsStubInterface;
use Spryker\Client\Kernel\AbstractFactory;

class ContactUsFactory extends AbstractFactory
{

    /**
     * @return \Pyz\Client\HelloSpryker\Zed\HelloSprykerZedStubInterface
     */
    public function createContactUsZedStub():ContactUsStubInterface
    {
        return new ContactUsStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient()
    {
        return $this->getProvidedDependency(ContactUsDependencyProvider::CLIENT_ZED_REQUEST);
    }

}
