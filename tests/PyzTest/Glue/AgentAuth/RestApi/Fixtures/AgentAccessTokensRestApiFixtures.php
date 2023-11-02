<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

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

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $userTransfer;

    /**
     * @param \PyzTest\Glue\AgentAuth\AgentAuthRestApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(AgentAuthRestApiTester $I): FixturesContainerInterface
    {
        $this->userTransfer = $this->createAgentUserTransfer($I);

        return $this;
    }

    /**
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function getUserTransfer(): UserTransfer
    {
        return $this->userTransfer;
    }

    /**
     * @param \PyzTest\Glue\AgentAuth\AgentAuthRestApiTester $I
     *
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    protected function createAgentUserTransfer(AgentAuthRestApiTester $I): UserTransfer
    {
        return $I->haveRegisteredAgent([
            UserTransfer::PASSWORD => static::TEST_PASSWORD,
        ]);
    }
}
