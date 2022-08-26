<?php

namespace Pyz\Client\Faq;

use Pyz\Client\Faq\Zed\FaqZedStub;
use Pyz\Client\Faq\Zed\FaqZedStubInterface;
use Pyz\Client\FaqsRestApi\FaqsRestApiDependencyProvider;
use Pyz\Client\FaqsRestApi\Zed\FaqsRestApiZedStub;
use Pyz\Client\FaqsRestApi\Zed\FaqsRestApiZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class FaqFactory extends AbstractFactory {

    public function createFaqZedStub(): FaqZedStubInterface
    {
        return new FaqZedStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(FaqDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
