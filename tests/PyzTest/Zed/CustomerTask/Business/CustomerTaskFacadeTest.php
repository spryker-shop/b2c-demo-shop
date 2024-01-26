<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\CustomerTask\Business;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\CustomerTaskBuilder;
use Generated\Shared\Transfer\CustomerTaskConditionsTransfer;
use Generated\Shared\Transfer\CustomerTaskCriteriaTransfer;
use Generated\Shared\Transfer\CustomerTaskTransfer;
use Pyz\Zed\CustomerTask\Business\Exception\CustomerNotFoundException;
use Pyz\Zed\CustomerTask\Business\Exception\CustomerTaskNotFoundException;
use PyzTest\Zed\CustomerTask\CustomerTaskBusinessTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group CustomerTask
 * @group Business
 * @group Facade
 * @group CustomerTaskFacadeTest
 * Add your own group annotations below this line
 */
class CustomerTaskFacadeTest extends Unit
{
    /**
     * @var \PyzTest\Zed\CustomerTask\CustomerTaskBusinessTester
     */
    protected CustomerTaskBusinessTester $tester;

    /**
     * @var int
     */
    private const NOT_EXISTENT_CUSTOMER_TASK_ID = 0;

    /**
     * @var string
     */
    private const NEW_TITLE = 'New title for test';

    /**
     * @var string
     */
    private const TAG = 'Test tag';

    /**
     * @var string
     */
    private const NOT_EXISTENT_CUSTOMER_EMAIL = 'email-not-exist';

    /**
     * @var string
     */
    private const EXCEPTION_MESSAGE_CUSTOMER_NOT_FOUND = 'Customer not found.';

    /**
     * @var string
     */
    private const EXCEPTION_MESSAGE_CUSTOMER_TASK_NOT_FOUND = 'Customer task not found.';

    /**
     * @return void
     */
    public function testGetCustomerTaskCollectionReturnsCustomerTaskCollection(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $customerTaskOneTransfer = $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $customerTaskTwoTransfer = $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $customerTaskIds = [
            $customerTaskOneTransfer->getIdCustomerTask(),
            $customerTaskTwoTransfer->getIdCustomerTask(),
        ];

        $customerTaskCriteriaTransfer = (new CustomerTaskCriteriaTransfer())->setCustomerTaskConditions(
            (new CustomerTaskConditionsTransfer())->setCustomerTaskIds($customerTaskIds),
        );

        // Act
        $customerTaskCollectionTransfer = $this->tester->getCustomerTaskFacade()->get($customerTaskCriteriaTransfer);

        // Assert
        $this->assertCount(2, $customerTaskCollectionTransfer->getCustomerTasks());
        $ids = [];
        foreach ($customerTaskCollectionTransfer->getCustomerTasks() as $customerTaskTransfer) {
            $ids[] = $customerTaskTransfer->getIdCustomerTask();
        }

        $this->assertTrue(in_array($customerTaskOneTransfer->getIdCustomerTask(), $ids));
        $this->assertTrue(in_array($customerTaskTwoTransfer->getIdCustomerTask(), $ids));
    }

    /**
     * @return void
     */
    public function testGetCustomerTaskCollectionReturnsEmptyCollectionForNotExistentCustomerTasks(): void
    {
        // Arrange
        $customerTaskCriteriaTransfer = (new CustomerTaskCriteriaTransfer())->setCustomerTaskConditions(
            (new CustomerTaskConditionsTransfer())->setIdCustomerTask(self::NOT_EXISTENT_CUSTOMER_TASK_ID),
        );

        // Act
        $customerTaskCollectionTransfer = $this->tester->getCustomerTaskFacade()->get($customerTaskCriteriaTransfer);

        // Assert
        $this->assertCount(0, $customerTaskCollectionTransfer->getCustomerTasks());
    }

    /**
     * @return void
     */
    public function testFindOneReturnsCustomerTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedCustomerTaskTransfer = $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $customerTaskCriteriaTransfer = (new CustomerTaskCriteriaTransfer())->setCustomerTaskConditions(
            (new CustomerTaskConditionsTransfer())->setIdCustomerTask($expectedCustomerTaskTransfer->getIdCustomerTask()),
        );

        // Act
        $customerTaskTransfer = $this->tester->getCustomerTaskFacade()->findOne($customerTaskCriteriaTransfer);

        // Assert
        $this->assertNotNull($customerTaskTransfer);
        $this->assertSame($expectedCustomerTaskTransfer->getIdCustomerTask(), $customerTaskTransfer->getIdCustomerTask());
    }

    /**
     * @return void
     */
    public function testFindOneReturnsNullForNotExistentCustomerTask(): void
    {
        // Arrange
        $customerTaskCriteriaTransfer = (new CustomerTaskCriteriaTransfer())->setCustomerTaskConditions(
            (new CustomerTaskConditionsTransfer())->setIdCustomerTask(self::NOT_EXISTENT_CUSTOMER_TASK_ID),
        );

        // Act
        $customerTaskTransfer = $this->tester->getCustomerTaskFacade()->findOne($customerTaskCriteriaTransfer);

        // Assert
        $this->assertNull($customerTaskTransfer);
    }

    /**
     * @return void
     */
    public function testCreateCreatesAndReturnsCustomerTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();

        $expectedCustomerTaskTransfer = (new CustomerTaskBuilder([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]))->build();

        // Act
        $customerTaskTransfer = $this->tester->getCustomerTaskFacade()->create($expectedCustomerTaskTransfer);

        // Assert
        $this->assertNotNull($customerTaskTransfer->getIdCustomerTask());
        $this->assertSame($expectedCustomerTaskTransfer->getTitle(), $customerTaskTransfer->getTitle());
        $this->assertSame($expectedCustomerTaskTransfer->getDescription(), $customerTaskTransfer->getDescription());
        $this->assertSame($expectedCustomerTaskTransfer->getFkCreator(), $customerTaskTransfer->getFkCreator());
        $this->assertSame($expectedCustomerTaskTransfer->getDueDate(), $customerTaskTransfer->getDueDate());
        $this->assertSame($expectedCustomerTaskTransfer->getStatus(), $customerTaskTransfer->getStatus());
    }

    /**
     * @return void
     */
    public function testUpdateUpdatesandReturnesCustomerTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedCustomerTaskTransfer = $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $oldTitle = $expectedCustomerTaskTransfer->getTitle();
        $expectedCustomerTaskTransfer->setTitle(self::NEW_TITLE);

        // Act
        $customerTasTransfer = $this->tester->getCustomerTaskFacade()->update($expectedCustomerTaskTransfer);

        // Assert
        $this->assertSame($expectedCustomerTaskTransfer->getTitle(), $customerTasTransfer->getTitle());
        $this->assertNotSame($oldTitle, $customerTasTransfer->getTitle());
    }

    /**
     * @return void
     */
    public function testDeleteDeletesCustomerTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedCustomerTaskTransfer = $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $customerTaskTwoTransfer = $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        $customerTaskCriteriaTransfer = (new CustomerTaskCriteriaTransfer())->setCustomerTaskConditions(
            (new CustomerTaskConditionsTransfer())->setIdCustomerTask($expectedCustomerTaskTransfer->getIdCustomerTask()),
        );

        // Act
        $result = $this->tester->getCustomerTaskFacade()->delete($expectedCustomerTaskTransfer);
        $customerTaskTransfer = $this->tester->getCustomerTaskFacade()->findOne($customerTaskCriteriaTransfer);

        // Assert
        $this->assertTrue($result);
        $this->assertNull($customerTaskTransfer);
    }

    /**
     * @return void
     */
    public function testAssignAssignsCustomerToCustomerTask(): void
    {
        // Arrange
        $customerCreatorTransfer = $this->tester->haveCustomer();
        $customerOwnerTransfer = $this->tester->haveCustomer();

        $expectedCustomerTaskOneTransfer = $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerCreatorTransfer->getIdCustomer(),
        ]);

        // Act
        $customerTaskTransfer = $this->tester->getCustomerTaskFacade()->assign(
            $customerOwnerTransfer->getEmail(),
            $expectedCustomerTaskOneTransfer->getIdCustomerTask(),
        );

        // Assert
        $this->assertSame($customerOwnerTransfer->getIdCustomer(), $customerTaskTransfer->getFkOwner());
    }

    /**
     * @return void
     */
    public function testAddTagAddsTagToCustomerTask(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedCustomerTaskOneTransfer = $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        // Act
        $customerTaskTransfer = $this->tester->getCustomerTaskFacade()->addTag(
            self::TAG,
            $expectedCustomerTaskOneTransfer->getIdCustomerTask(),
        );

        // Assert
        $this->assertCount(1, $customerTaskTransfer->getTags());
        /** @var \Generated\Shared\Transfer\CustomerTaskTagTransfer $customerTaskTagTransfer */
        $customerTaskTagTransfer = $customerTaskTransfer->getTags()->offsetGet(0);

        $this->assertSame(self::TAG, $customerTaskTagTransfer->getTag());
    }

    /**
     * @return void
     */
    public function testAssignToNotExistentCustomerThrowsException(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $expectedCustomerTaskOneTransfer = $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        // Assert
        $this->expectException(CustomerNotFoundException::class);
        $this->expectExceptionMessage(self::EXCEPTION_MESSAGE_CUSTOMER_NOT_FOUND);

        // Act
        $this->tester->getCustomerTaskFacade()->assign(
            self::NOT_EXISTENT_CUSTOMER_EMAIL,
            $expectedCustomerTaskOneTransfer->getIdCustomerTask(),
        );
    }

    /**
     * @return void
     */
    public function testAssignToNotExistentCustomerNoteThrowsException(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        // Assert
        $this->expectException(CustomerTaskNotFoundException::class);
        $this->expectExceptionMessage(self::EXCEPTION_MESSAGE_CUSTOMER_TASK_NOT_FOUND);

        // Act
        $this->tester->getCustomerTaskFacade()->assign(
            $customerTransfer->getEmail(),
            self::NOT_EXISTENT_CUSTOMER_TASK_ID,
        );
    }

    /**
     * @return void
     */
    public function testAddTagToNotExistentCustomerNoteThrowsException(): void
    {
        // Arrange
        $customerTransfer = $this->tester->haveCustomer();
        $this->tester->haveCustomerTask([
            CustomerTaskTransfer::FK_CREATOR => $customerTransfer->getIdCustomer(),
        ]);

        // Assert
        $this->expectException(CustomerTaskNotFoundException::class);
        $this->expectExceptionMessage(self::EXCEPTION_MESSAGE_CUSTOMER_TASK_NOT_FOUND);

        // Act
        $this->tester->getCustomerTaskFacade()->addTag(
            self::TAG,
            self::NOT_EXISTENT_CUSTOMER_TASK_ID,
        );
    }
}
