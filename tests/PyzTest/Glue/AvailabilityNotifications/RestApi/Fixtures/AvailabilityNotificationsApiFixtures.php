<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\AvailabilityNotifications\RestApi\Fixtures;

use Generated\Shared\Transfer\CustomerTransfer;
use PyzTest\Glue\AvailabilityNotifications\AvailabilityNotificationsRestApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group AvailabilityNotifications
 * @group RestApi
 * @group AvailabilityNotificationsApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class AvailabilityNotificationsApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'UserRestApiFixtures';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerTransfer;

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    /**
     * @param \PyzTest\Glue\AvailabilityNotifications\AvailabilityNotificationsRestApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(AvailabilityNotificationsRestApiTester $I): FixturesContainerInterface
    {
        $this->customerTransfer = $this->createCustomer($I);
        $this->customerTransfer = $I->confirmCustomer($this->customerTransfer);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\AvailabilityNotifications\AvailabilityNotificationsRestApiTester $I
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function createCustomer(AvailabilityNotificationsRestApiTester $I): CustomerTransfer
    {
        return $I->haveCustomer([
            CustomerTransfer::USERNAME => static::TEST_USERNAME,
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);
    }
}
