<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Business\Mail;

use ArrayObject;
use Generated\Shared\Transfer\CustomerTaskConditionsTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Pyz\Zed\CustomerTask\Communication\Plugin\Mail\CustomerTaskOverdueMailTypeBuilderPlugin;
use Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

class OverdueTaskNotifier implements OverdueTaskNotifierInterface
{
    /**
     * @var \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface
     */
    private CustomerTaskRepositoryInterface $customerTaskRepository;

    /**
     * @var \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    private MailFacadeInterface $mailFacade;

    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    private CustomerFacadeInterface $customerFacade;

    /**
     * @param \Pyz\Zed\CustomerTask\Persistence\CustomerTaskRepositoryInterface $customerTaskRepository
     * @param \Spryker\Zed\Mail\Business\MailFacadeInterface $mailFacade
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     */
    public function __construct(
        CustomerTaskRepositoryInterface $customerTaskRepository,
        MailFacadeInterface $mailFacade,
        CustomerFacadeInterface $customerFacade,
    ) {
        $this->customerTaskRepository = $customerTaskRepository;
        $this->mailFacade = $mailFacade;
        $this->customerFacade = $customerFacade;
    }

    /**
     * @return void
     */
    public function notify(): void
    {
        $customerTaskCollectionTransfer = $this->customerTaskRepository->get($this->prepareCriteriaTransfer());
        foreach ($customerTaskCollectionTransfer->getCustomerTasks() as $customerTaskTransfer) {
            $this->sendMail($customerTaskTransfer);
        }
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTaskCriteriaTransfer
     */
    private function prepareCriteriaTransfer(): CustomerTaskCriteriaTransfer
    {
        $ustomerTaskCriteriaTransfer = new CustomerTaskCriteriaTransfer();
        $ustomerTaskCriteriaTransfer->setCustomerTaskConditions(
            (new CustomerTaskConditionsTransfer())->setIsOverdue(true),
        );

        return $ustomerTaskCriteriaTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTaskTransfer $customerTaskTransfer
     *
     * @return void
     */
    private function sendMail(CustomerTaskTransfer $customerTaskTransfer): void
    {
        $customerTransfer = $this->customerFacade->findCustomerById(
            (new CustomerTransfer())->setIdCustomer($customerTaskTransfer->getFkCreator()),
        );

        if (!$customerTransfer) {
            return;
        }

        $recipientName = sprintf('%s %s', $customerTransfer->getFirstName(), $customerTransfer->getLastName());

        $recipients = new ArrayObject([
            (new MailRecipientTransfer())->setEmail($customerTransfer->getEmail())
                ->setName($recipientName),
        ]);

        $mailTransfer = (new MailTransfer())
            ->setType(CustomerTaskOverdueMailTypeBuilderPlugin::MAIL_TYPE)
            ->setRecipients($recipients);

        $mailTransfer->offsetSet('taskTitle', $customerTaskTransfer->getTitle());
        $mailTransfer->offsetSet('taskDueDate', $customerTaskTransfer->getDueDate());
        $mailTransfer->offsetSet('recipientName', $recipientName);

        $this->mailFacade->handleMail($mailTransfer);
    }
}
