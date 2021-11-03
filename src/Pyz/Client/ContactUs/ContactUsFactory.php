<?php

namespace Pyz\Client\ContactUs;

use Pyz\Client\ContactUs\Zed\ContactUsStub;
use Spryker\Client\Kernel\AbstractFactory;

class ContactUsFactory extends AbstractFactory
{

    /**
     * @return \Pyz\Client\ContactUs\Zed\ContactUsStubInterface
     */
    public function createZedStub()
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
