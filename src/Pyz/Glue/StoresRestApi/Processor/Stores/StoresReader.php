<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Glue\StoresRestApi\Processor\Stores;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\StoresRestApi\Processor\Stores\StoresReader as SprykerStoresReader;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Temporary workaround: since spryker/store 1.41 the Store client throws a NotFoundHttpException for an unknown
 * store name, but spryker/stores-rest-api 1.6 still expects an empty transfer and lets the exception escape as a 500.
 * Remove once StoresRestApi handles the exception itself.
 */
class StoresReader extends SprykerStoresReader
{
    protected function getDynamicStoreStoresAttributes(RestRequestInterface $restRequest): RestResponseInterface
    {
        try {
            return parent::getDynamicStoreStoresAttributes($restRequest);
        } catch (NotFoundHttpException) {
            return $this->getInvalidStoreRestResponse();
        }
    }
}
