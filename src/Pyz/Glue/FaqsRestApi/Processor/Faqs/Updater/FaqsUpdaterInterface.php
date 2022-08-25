<?php

namespace Pyz\Glue\FaqsRestApi\Processor\Faqs\Updater;

use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

interface FaqsUpdaterInterface {

    public function updateFaqEntity(RestRequestInterface $restRequest, FaqTransfer $trans): RestResponseInterface;
}
