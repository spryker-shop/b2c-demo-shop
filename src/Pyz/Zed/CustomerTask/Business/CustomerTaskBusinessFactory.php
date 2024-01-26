<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business;

use Pyz\Zed\CustomerTask\Business\CustomerTask\Assigner;
use Pyz\Zed\CustomerTask\Business\CustomerTask\AssignerInterface;
use Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskCreator;
use Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskCreatorInterface;
use Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskDeleter;
use Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskDeleterInterface;
use Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskReader;
use Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskReaderInterface;
use Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskUpdater;
use Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskUpdaterInterface;
use Pyz\Zed\CustomerTask\Business\CustomerTaskTag\TagAdder;
use Pyz\Zed\CustomerTask\Business\CustomerTaskTag\TagAdderInterface;
use Pyz\Zed\CustomerTask\Business\Mail\OverdueTaskNotifier;
use Pyz\Zed\CustomerTask\Business\Mail\OverdueTaskNotifierInterface;
use Pyz\Zed\CustomerTask\CustomerTaskDependencyProvider;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

/**
 * @method \Pyz\Zed\CustomerTask\CustomerTaskConfig getConfig()
 * @method \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface getRepository()
 * @method \Pyz\Zed\CustomerTask\Persistence\CustomerTaskEntityManagerInterface getEntityManager()
 */
class CustomerTaskBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskReaderInterface
     */
    public function createCustomerTaskReader(): CustomerTaskReaderInterface
    {
        return new CustomerTaskReader($this->getRepository());
    }

    /**
     * @return \Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskCreatorInterface
     */
    public function createCustomerTaskCreator(): CustomerTaskCreatorInterface
    {
        return new CustomerTaskCreator($this->getEntityManager());
    }

    /**
     * @return \Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskUpdaterInterface
     */
    public function createCustomerTaskUpdater(): CustomerTaskUpdaterInterface
    {
        return new CustomerTaskUpdater($this->getEntityManager());
    }

    /**
     * @return \Pyz\Zed\CustomerTask\Business\CustomerTask\CustomerTaskDeleterInterface
     */
    public function createCustomerTaskDeleter(): CustomerTaskDeleterInterface
    {
        return new CustomerTaskDeleter($this->getEntityManager());
    }

    /**
     * @return \Pyz\Zed\CustomerTask\Business\Mail\OverdueTaskNotifierInterface
     */
    public function createOverdueTaskNotifier(): OverdueTaskNotifierInterface
    {
        return new OverdueTaskNotifier(
            $this->getRepository(),
            $this->getMailFacade(),
            $this->getCustomerFacade(),
        );
    }

    /**
     * @return \Pyz\Zed\CustomerTask\Business\CustomerTask\AssignerInterface
     */
    public function createAssigner(): AssignerInterface
    {
        return new Assigner(
            $this->getCustomerFacade(),
            $this->getRepository(),
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Pyz\Zed\CustomerTask\Business\CustomerTaskTag\TagAdderInterface
     */
    public function createTagAdder(): TagAdderInterface
    {
        return new TagAdder(
            $this->getRepository(),
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    public function getMailFacade(): MailFacadeInterface
    {
        return $this->getProvidedDependency(CustomerTaskDependencyProvider::FACADE_MAIL);
    }

    /**
     * @return \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    public function getCustomerFacade(): CustomerFacadeInterface
    {
        return $this->getProvidedDependency(CustomerTaskDependencyProvider::FACADE_CUSTOMER);
    }
}
