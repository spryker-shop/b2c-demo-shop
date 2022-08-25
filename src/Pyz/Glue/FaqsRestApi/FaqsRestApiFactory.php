<?php

namespace Pyz\Glue\FaqsRestApi;


use Pyz\Glue\FaqsRestApi\Processor\Faqs\Reader\FaqsReader;
use Pyz\Glue\FaqsRestApi\Processor\Faqs\Reader\FaqsReaderInterface;
use Pyz\Glue\FaqsRestApi\Processor\Mapper\FaqsResourceMapper;
use Spryker\Glue\Kernel\AbstractFactory;


/**
 * @method \Pyz\Client\FaqsRestApi\FaqsRestApiClientInterface getClient()
 */
class FaqsRestApiFactory extends AbstractFactory{

    public function createFaqsResourceMapper(): FaqsResourceMapper
    {
        return new FaqsResourceMapper();
    }

    public function createFaqsReader(): FaqsReaderInterface
    {
        return new FaqsReader(
            $this->getClient(),
            $this->getResourceBuilder(),
            $this->createFaqsResourceMapper()
        );
    }

}
