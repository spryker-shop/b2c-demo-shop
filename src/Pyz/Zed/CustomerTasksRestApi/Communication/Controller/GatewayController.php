<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTasksRestApi\Communication\Controller;

use Exception;
use Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskResponseTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer;
use Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Pyz\Zed\CustomerTasksRestApi\Communication\CustomerTasksRestApiCommunicationFactory getFactory()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE_TASK_NOT_FOUND = 'Task not found.';

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer
     */
    public function getAction(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskCollectionResponseTransfer
    {
        $customerTaskCollectionResponseTransfer = (new CustomerTaskCollectionResponseTransfer())->setIsSuccessful(false);

        try {
            $customerTaskCollectionTransfer = $this->getFactory()
                ->getCustomerTaskFacade()
                ->get($customerTaskCriteriaTransfer);
            $customerTaskCollectionResponseTransfer->setCustomerTasks($customerTaskCollectionTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessageForCollection($customerTaskCollectionResponseTransfer, $exception);
        }

        return $customerTaskCollectionResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function getOneAction(CustomerTaskCriteriaTransfer $customerTaskCriteriaTransfer): CustomerTaskResponseTransfer
    {
        $customerTaskResponseTransfer = (new CustomerTaskResponseTransfer())->setIsSuccessful(false);

        try {
            $customerTaskTransfer = $this->getFactory()
                ->getCustomerTaskFacade()
                ->findOne($customerTaskCriteriaTransfer);

            if (!$customerTaskTransfer) {
                return $customerTaskResponseTransfer->addMessage(
                    (new MessageTransfer())->setMessage(self::ERROR_MESSAGE_TASK_NOT_FOUND),
                );
            }

            $customerTaskResponseTransfer->setCustomerTask($customerTaskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($customerTaskResponseTransfer, $exception);
        }

        return $customerTaskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function createAction(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer
    {
        $customerTaskResponseTransfer = (new CustomerTaskResponseTransfer())->setIsSuccessful(false);

        try {
            $customerTaskTransfer = $this->getFactory()
                ->getCustomerTaskFacade()
                ->create($customerTaskTransfer);

            $customerTaskResponseTransfer->setCustomerTask($customerTaskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($customerTaskResponseTransfer, $exception);
        }

        return $customerTaskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function updateAction(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer
    {
        $customerTaskResponseTransfer = (new CustomerTaskResponseTransfer())->setIsSuccessful(false);

        try {
            $customerTaskTransfer = $this->getFactory()
                ->getCustomerTaskFacade()
                ->update($customerTaskTransfer);

            $customerTaskResponseTransfer->setCustomerTask($customerTaskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($customerTaskResponseTransfer, $exception);
        }

        return $customerTaskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function deleteAction(CustomerTaskTransfer $customerTaskTransfer): CustomerTaskResponseTransfer
    {
        $customerTaskResponseTransfer = (new CustomerTaskResponseTransfer())->setIsSuccessful(false);

        try {
            $result = $this->getFactory()
                ->getCustomerTaskFacade()
                ->delete($customerTaskTransfer);

            $customerTaskResponseTransfer->setIsSuccessful($result);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($customerTaskResponseTransfer, $exception);
        }

        return $customerTaskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function assignAction(RestCustomerTaskAssignRequestTransfer $restCustomerTaskAssignRequestTransfer): CustomerTaskResponseTransfer
    {
        $customerTaskResponseTransfer = (new CustomerTaskResponseTransfer())->setIsSuccessful(false);

        try {
            $customerTaskTransfer = $this->getFactory()
                ->getCustomerTaskFacade()
                ->assign(
                    $restCustomerTaskAssignRequestTransfer->getEmail(),
                    $restCustomerTaskAssignRequestTransfer->getIdCustomerTask(),
                );

            $customerTaskResponseTransfer->setCustomerTask($customerTaskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($customerTaskResponseTransfer, $exception);
        }

        return $customerTaskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    public function addTagAction(RestCustomerTaskTagRequestTransfer $restCustomerTaskTagRequestTransfer): CustomerTaskResponseTransfer
    {
        $customerTaskResponseTransfer = (new CustomerTaskResponseTransfer())->setIsSuccessful(false);

        try {
            $customerTaskTransfer = $this->getFactory()
                ->getCustomerTaskFacade()
                ->addTag(
                    $restCustomerTaskTagRequestTransfer->getTag(),
                    $restCustomerTaskTagRequestTransfer->getIdCustomerTask(),
                );

            $customerTaskResponseTransfer->setCustomerTask($customerTaskTransfer)
                ->setIsSuccessful(true);
        } catch (Exception $exception) {
            return $this->handleErrorMessage($customerTaskResponseTransfer, $exception);
        }

        return $customerTaskResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer $responseTransfer
     * @param \Exception $exception
     *
     * @return \Generated\Shared\Transfer\CustomerTaskCollectionResponseTransfer
     */
    private function handleErrorMessageForCollection(
        CustomerTaskCollectionResponseTransfer $responseTransfer,
        Exception $exception,
    ): CustomerTaskCollectionResponseTransfer {
        $messageTransfer = (new MessageTransfer())->setMessage($exception->getMessage());
        $responseTransfer->addMessage($messageTransfer);

        return $responseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskResponseTransfer $responseTransfer
     * @param \Exception $exception
     *
     * @return \Generated\Shared\Transfer\CustomerTaskResponseTransfer
     */
    private function handleErrorMessage(
        CustomerTaskResponseTransfer $responseTransfer,
        Exception $exception,
    ): CustomerTaskResponseTransfer {
        $messageTransfer = (new MessageTransfer())->setMessage($exception->getMessage());
        $responseTransfer->addMessage($messageTransfer);

        return $responseTransfer;
    }
}
