<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Glue\CustomerTasksRestApi;

use Pyz\Glue\CustomerTasksRestApi\Processor\Assign\CustomerTaskAssigner;
use Pyz\Glue\CustomerTasksRestApi\Processor\Assign\CustomerTaskAssignerInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskCreator;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskCreatorInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskDeleter;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskDeleterInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskReader;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskReaderInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskUpdater;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskUpdaterInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTaskTag\CustomerTaskTagAdder;
use Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTaskTag\CustomerTaskTagAdderInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\Mapper\CustomerTaskMapper;
use Pyz\Glue\CustomerTasksRestApi\Processor\Mapper\CustomerTaskMapperInterface;
use Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilder;
use Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

/**
 * @method \Pyz\Client\CustomerTasksRestApi\CustomerTasksRestApiClientInterface getClient()
 */
class CustomerTasksRestApiFactory extends AbstractFactory
{
    /**
     * @return \Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskReaderInterface
     */
    public function createCustomerTaskReader(): CustomerTaskReaderInterface
    {
        return new CustomerTaskReader(
            $this->getClient(),
            $this->createCustomerTaskRestResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskCreatorInterface
     */
    public function createCustomerTaskCreator(): CustomerTaskCreatorInterface
    {
        return new CustomerTaskCreator(
            $this->getClient(),
            $this->createCustomerTaskRestResponseBuilder(),
            $this->createCustomerTaskMapper(),
        );
    }

    /**
     * @return \Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskUpdaterInterface
     */
    public function createCustomerTaskUpdater(): CustomerTaskUpdaterInterface
    {
        return new CustomerTaskUpdater(
            $this->getClient(),
            $this->createCustomerTaskRestResponseBuilder(),
            $this->createCustomerTaskMapper(),
        );
    }

    /**
     * @return \Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTasks\CustomerTaskDeleterInterface
     */
    public function createCustomerTaskDeleter(): CustomerTaskDeleterInterface
    {
        return new CustomerTaskDeleter(
            $this->getClient(),
            $this->createCustomerTaskRestResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\CustomerTasksRestApi\Processor\Mapper\CustomerTaskMapperInterface
     */
    public function createCustomerTaskMapper(): CustomerTaskMapperInterface
    {
        return new CustomerTaskMapper();
    }

    /**
     * @return \Pyz\Glue\CustomerTasksRestApi\Processor\RestResponseBuilder\CustomerTaskRestResponseBuilderInterface
     */
    public function createCustomerTaskRestResponseBuilder(): CustomerTaskRestResponseBuilderInterface
    {
        return new CustomerTaskRestResponseBuilder(
            $this->createCustomerTaskMapper(),
            $this->getResourceBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\CustomerTasksRestApi\Processor\Assign\CustomerTaskAssignerInterface
     */
    public function createCustomerTaskAssigner(): CustomerTaskAssignerInterface
    {
        return new CustomerTaskAssigner(
            $this->getClient(),
            $this->createCustomerTaskRestResponseBuilder(),
        );
    }

    /**
     * @return \Pyz\Glue\CustomerTasksRestApi\Processor\CustomerTaskTag\CustomerTaskTagAdderInterface
     */
    public function createCustomerTaskTagAdder(): CustomerTaskTagAdderInterface
    {
        return new CustomerTaskTagAdder(
            $this->getClient(),
            $this->createCustomerTaskRestResponseBuilder(),
        );
    }
}
