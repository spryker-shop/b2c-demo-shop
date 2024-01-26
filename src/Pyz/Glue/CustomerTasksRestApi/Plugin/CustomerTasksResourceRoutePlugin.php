<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi\Plugin;

use Generated\Shared\Transfer\RestCustomerTaskAttributesTransfer;
use Pyz\Glue\CustomerTasksRestApi\CustomerTasksRestApiConfig;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class CustomerTasksResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
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
        $resourceRouteCollection
            ->addPost('post')
            ->addPatch('patch')
            ->addDelete('delete')
            ->addGet('get');

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
        return CustomerTasksRestApiConfig::RESOURCE_CUSTOMER_TASKS;
    }

    /**
     * @inheritDoc
     */
    public function getController(): string
    {
        return 'customer-tasks-resource';
    }

    /**
     * @inheritDoc
     */
    public function getResourceAttributesClassName(): string
    {
        return RestCustomerTaskAttributesTransfer::class;
    }
}
