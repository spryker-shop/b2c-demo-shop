<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Customer\RestApi;

use Generated\Shared\Transfer\CustomerTransfer;
use PyzTest\Glue\Customer\CustomerApiTester;
use RuntimeException;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Customer
 * @group RestApi
 * @group CustomerRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class CustomerRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerTransfer;

    /**
     * @throws \RuntimeException
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerTransfer(): CustomerTransfer
    {
        if (!$this->customerTransfer instanceof CustomerTransfer) {
            throw new RuntimeException('Customer is empty, run `codecept fixtures` first');
        }

        return $this->customerTransfer;
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $i
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(CustomerApiTester $i): FixturesContainerInterface
    {
        $this->createCustomer($i);
        $this->confirmCustomer($i);

        return $this;
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $i
     *
     * @return void
     */
    protected function createCustomer(CustomerApiTester $i): void
    {
        $customerTransfer = $i->haveCustomer([
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        $this->customerTransfer = $customerTransfer;
    }

    /**
     * @param \PyzTest\Glue\Customer\CustomerApiTester $i
     *
     * @return void
     */
    protected function confirmCustomer(CustomerApiTester $i): void
    {
        $this->customerTransfer = $i->confirmCustomer($this->customerTransfer);
    }
}
