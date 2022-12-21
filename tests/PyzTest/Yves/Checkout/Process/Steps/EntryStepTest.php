<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Checkout\Process\Steps;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\Customer\CustomerClient;
use SprykerShop\Yves\CheckoutPage\Process\Steps\EntryStep;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Yves
 * @group Checkout
 * @group Process
 * @group Steps
 * @group EntryStepTest
 * Add your own group annotations below this line
 */
class EntryStepTest extends Unit
{
    /**
     * @return void
     */
    public function testRequireInputShouldReturnFalse(): void
    {
        $entryStep = $this->createEntryStep();
        $this->assertFalse($entryStep->requireInput(new QuoteTransfer()));
    }

    /**
     * @return void
     */
    public function testPostConditionShouldReturnTrue(): void
    {
        $entryStep = $this->createEntryStep();

        $this->assertTrue($entryStep->postCondition(new QuoteTransfer()));
    }

    /**
     * @return void
     */
    public function testPreConditionShouldReturnFalseIfCarIsEmpty(): void
    {
        $entryStep = $this->createEntryStep();
        $this->assertFalse($entryStep->preCondition(new QuoteTransfer()));
    }

    /**
     * @return \SprykerShop\Yves\CheckoutPage\Process\Steps\EntryStep
     */
    protected function createEntryStep(): EntryStep
    {
        return new EntryStep(
            'entry_route',
            'escape_route',
        );
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequest(): Request
    {
        return Request::createFromGlobals();
    }

    /**
     * @return \Spryker\Client\Customer\CustomerClient
     */
    protected function createCustomerClient(): CustomerClient
    {
        return new CustomerClient();
    }
}
