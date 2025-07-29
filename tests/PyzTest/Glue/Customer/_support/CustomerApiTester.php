<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Customer;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestCustomersAttributesTransfer;
use SprykerTest\Glue\Testify\Tester\ApiEndToEndTester;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(\PyzTest\Glue\Customer\PHPMD)
 */
class CustomerApiTester extends ApiEndToEndTester
{
    use _generated\CustomerApiTesterActions;

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param array<string> $restCustomersAttributesTransferData
     *
     * @return void
     */
    public function assertCustomersAttributes(
        CustomerTransfer $customerTransfer,
        array $restCustomersAttributesTransferData,
    ): void {
        $restCustomersAttributesTransfer = (new RestCustomersAttributesTransfer())
            ->fromArray($restCustomersAttributesTransferData, true);

        $this->assertSame(
            $customerTransfer->getEmail(),
            $restCustomersAttributesTransfer->getEmail(),
        );
        $this->assertSame(
            $customerTransfer->getFirstName(),
            $restCustomersAttributesTransfer->getFirstName(),
        );
        $this->assertSame(
            $customerTransfer->getLastName(),
            $restCustomersAttributesTransfer->getLastName(),
        );
        $this->assertSame(
            substr($customerTransfer->getCreatedAt(), 0, 19),
            substr($restCustomersAttributesTransfer->getCreatedAt(), 0, 19),
        );
        $this->assertSame(
            substr($customerTransfer->getUpdatedAt(), 0, 19),
            substr($restCustomersAttributesTransfer->getUpdatedAt(), 0, 19),
        );
        $this->assertSame(
            $customerTransfer->getDateOfBirth(),
            $restCustomersAttributesTransfer->getDateOfBirth(),
        );
        $this->assertSame(
            $customerTransfer->getGender(),
            $restCustomersAttributesTransfer->getGender(),
        );
        $this->assertSame(
            $customerTransfer->getSalutation(),
            $restCustomersAttributesTransfer->getSalutation(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestCustomersAttributesTransfer $expectedRestCustomersAttributesTransfer
     * @param array $restCustomersAttributesTransferData
     *
     * @return void
     */
    public function assertRegisteredCustomersAttributes(
        RestCustomersAttributesTransfer $expectedRestCustomersAttributesTransfer,
        array $restCustomersAttributesTransferData,
    ): void {
        $restCustomersAttributesTransfer = (new RestCustomersAttributesTransfer())
            ->fromArray($restCustomersAttributesTransferData, true);

        $this->assertSame(
            $expectedRestCustomersAttributesTransfer->getEmail(),
            $restCustomersAttributesTransfer->getEmail(),
        );
        $this->assertSame(
            $expectedRestCustomersAttributesTransfer->getFirstName(),
            $restCustomersAttributesTransfer->getFirstName(),
        );
        $this->assertSame(
            $expectedRestCustomersAttributesTransfer->getLastName(),
            $restCustomersAttributesTransfer->getLastName(),
        );
        $this->assertSame(
            $expectedRestCustomersAttributesTransfer->getDateOfBirth(),
            $restCustomersAttributesTransfer->getDateOfBirth(),
        );
        $this->assertSame(
            $expectedRestCustomersAttributesTransfer->getGender(),
            $restCustomersAttributesTransfer->getGender(),
        );
        $this->assertSame(
            $expectedRestCustomersAttributesTransfer->getSalutation(),
            $restCustomersAttributesTransfer->getSalutation(),
        );
    }
}
