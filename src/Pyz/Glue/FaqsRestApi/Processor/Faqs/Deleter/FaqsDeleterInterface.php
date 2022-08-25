<?php

namespace Pyz\Glue\FaqsRestApi\Processor\Faqs\Deleter;

use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface FaqsDeleterInterface {

    public function deleteFaqEntity(RestRequestInterface $restRequest, FaqTransfer $trans): RestResponseInterface;
}
