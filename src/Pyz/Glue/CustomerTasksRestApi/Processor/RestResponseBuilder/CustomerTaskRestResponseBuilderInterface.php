<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder;

use ArrayObject;
use Generated\Shared\Transfer\CustomerTaskCollectionTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface CustomerTaskRestResponseBuilderInterface
{
    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createMissingAccessTokenErrorResponse(): RestResponseInterface;

    /**
     * @param \ArrayObject<int,\Generated\Shared\Transfer\MessageTransfer> $errorMessages
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createRestErrorResponse(ArrayObject $errorMessages): RestResponseInterface;

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCollectionTransfer $customerTaskCollectionTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCustomerTaskCollectionRestResponse(CustomerTaskCollectionTransfer $customerTaskCollectionTransfer): RestResponseInterface;

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer|null $customerTaskTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createCustomerTaskRestResponse(?CustomerTaskTransfer $customerTaskTransfer = null): RestResponseInterface;

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createEmptyResponse(): RestResponseInterface;
}
