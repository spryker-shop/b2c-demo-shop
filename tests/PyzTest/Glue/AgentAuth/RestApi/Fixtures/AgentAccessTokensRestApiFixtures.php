<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\AgentAuth\RestApi\Fixtures;

use Generated\Shared\Transfer\UserTransfer;
use PyzTest\Glue\AgentAuth\AgentAuthRestApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class AgentAccessTokensRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    public const TEST_PASSWORD = 'change123';

    protected UserTransfer $userTransfer;

    public function buildFixtures(AgentAuthRestApiTester $I): FixturesContainerInterface
    {
        $this->userTransfer = $this->createAgentUserTransfer($I);

        return $this;
    }

    public function getUserTransfer(): UserTransfer
    {
        return $this->userTransfer;
    }

    protected function createAgentUserTransfer(AgentAuthRestApiTester $I): UserTransfer
    {
        return $I->haveRegisteredAgent([
            UserTransfer::PASSWORD => static::TEST_PASSWORD,
        ]);
    }
}
