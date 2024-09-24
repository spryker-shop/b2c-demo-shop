<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\Auth\RestApi;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OauthResponseTransfer;
use PyzTest\Glue\Auth\AuthRestApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class RefreshTokensRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    /**
     * @var \Generated\Shared\Transfer\OauthResponseTransfer
     */
    protected OauthResponseTransfer $oauthResponseTransfer;

    /**
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(AuthRestApiTester $I): FixturesContainerInterface
    {
        $this->oauthResponseTransfer = $this->createOauthResponseTransfer($I);

        return $this;
    }

    /**
     * @return \Generated\Shared\Transfer\OauthResponseTransfer
     */
    public function getOauthResponseTransfer(): OauthResponseTransfer
    {
        return $this->oauthResponseTransfer;
    }

    /**
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return \Generated\Shared\Transfer\OauthResponseTransfer
     */
    protected function createOauthResponseTransfer(AuthRestApiTester $I): OauthResponseTransfer
    {
        $customerTransfer = $this->createCustomerTransfer($I);
        $customerTransfer = $I->confirmCustomer($customerTransfer);

        return $I->haveAuthorizationToGlue($customerTransfer);
    }

    /**
     * @param \PyzTest\Glue\Auth\AuthRestApiTester $I
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function createCustomerTransfer(AuthRestApiTester $I): CustomerTransfer
    {
        return $I->haveCustomer([
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);
    }
}
