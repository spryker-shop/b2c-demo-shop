<?php

namespace Pyz\Glue\FaqsRestApi\Processor\Faqs\Reader;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;


interface FaqsReaderInterface {

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getFaqs(RestRequestInterface $restRequest): RestResponseInterface;


    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getFaq(RestRequestInterface $restRequest, int $id): RestResponseInterface;
}
