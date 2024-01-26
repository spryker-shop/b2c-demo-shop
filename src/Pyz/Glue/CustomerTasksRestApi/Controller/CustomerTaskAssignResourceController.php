<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Controller;

use Generated\Shared\Transfer\RestCustomerTaskAssignAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \Pyz\Glue\CustomerTasksRestApi\CustomerTasksRestApiFactory getFactory()
 */
class CustomerTaskAssignResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "post": {
     *          "summary": [
     *              "Add tag to task."
     *          ],
     *          "parameters": [{
     *              "ref": "acceptLanguage"
     *          }],
     *          "responses": {
     *              "422": "Unprocessable entity."
     *          }
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestCustomerTaskAssignAttributesTransfer $restCustomerTaskAssignAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function patchAction(
        RestRequestInterface $restRequest,
        RestCustomerTaskAssignAttributesTransfer $restCustomerTaskAssignAttributesTransfer,
    ): RestResponseInterface {
        return $this->getFactory()
            ->createCustomerTaskAssigner()
            ->assign($restCustomerTaskAssignAttributesTransfer, $restRequest);
    }
}
