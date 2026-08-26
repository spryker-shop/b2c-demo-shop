<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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
    public function testRequireInputShouldReturnFalse(): void
    {
        $entryStep = $this->createEntryStep();
        $this->assertFalse($entryStep->requireInput(new QuoteTransfer()));
    }

    public function testPostConditionShouldReturnTrue(): void
    {
        $entryStep = $this->createEntryStep();

        $this->assertTrue($entryStep->postCondition(new QuoteTransfer()));
    }

    public function testPreConditionShouldReturnFalseIfCarIsEmpty(): void
    {
        $entryStep = $this->createEntryStep();
        $this->assertFalse($entryStep->preCondition(new QuoteTransfer()));
    }

    protected function createEntryStep(): EntryStep
    {
        return new EntryStep(
            'entry_route',
            'escape_route',
        );
    }

    protected function createRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function createCustomerClient(): CustomerClient
    {
        return new CustomerClient();
    }
}
