<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

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

    protected OauthResponseTransfer $oauthResponseTransfer;

    public function buildFixtures(AuthRestApiTester $I): FixturesContainerInterface
    {
        $this->oauthResponseTransfer = $this->createOauthResponseTransfer($I);

        return $this;
    }

    public function getOauthResponseTransfer(): OauthResponseTransfer
    {
        return $this->oauthResponseTransfer;
    }

    protected function createOauthResponseTransfer(AuthRestApiTester $I): OauthResponseTransfer
    {
        $customerTransfer = $this->createCustomerTransfer($I);
        $customerTransfer = $I->confirmCustomer($customerTransfer);

        return $I->haveAuthorizationToGlue($customerTransfer);
    }

    protected function createCustomerTransfer(AuthRestApiTester $I): CustomerTransfer
    {
        return $I->haveCustomer([
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);
    }
}
