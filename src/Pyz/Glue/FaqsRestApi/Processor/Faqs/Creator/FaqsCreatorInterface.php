<?php

namespace Pyz\Glue\FaqsRestApi\Processor\Faqs\Creator;

use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface FaqsCreatorInterface {

    public function createFaqEntity(RestRequestInterface $restRequest, FaqTransfer $trans): RestResponseInterface;
}
