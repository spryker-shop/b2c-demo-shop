<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Plugin;

use Generated\Shared\Transfer\RestCustomerTaskAssignAttributesTransfer;
use Pyz\Glue\CustomerTasksRestApi\CustomerTasksRestApiConfig;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CustomerTaskAssignResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection): ResourceRouteCollectionInterface
    {
        $resourceRouteCollection->addPatch('patch');

        return $resourceRouteCollection;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceType(): string
    {
        return CustomerTasksRestApiConfig::RESOURCE_CUSTOMER_TASK_ASSIGN;
    }

    /**
     * @inheritDoc
     */
    public function getController(): string
    {
        return 'customer-task-assign-resource';
    }

    /**
     * @inheritDoc
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCustomerTaskAssignAttributesTransfer::class;
    }
}
