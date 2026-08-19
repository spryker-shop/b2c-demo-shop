<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\MultiFactorAuth\StorefrontApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\MultiFactorAuth\MultiFactorAuthStorefrontApiTester;
use PyzTest\Glue\MultiFactorAuth\StorefrontApi\Fixtures\MultiFactorAuthStorefrontApiFixtures;
use Spryker\Glue\MultiFactorAuth\MultiFactorAuthConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group MultiFactorAuth
 * @group StorefrontApi
 * @group MultiFactorAuthStorefrontApiCest
 * Add your own group annotations below this line
 */
class MultiFactorAuthStorefrontApiCest
{
    protected ?string $mfaCode = null;

    /**
     * @var string
     */
    protected const INVALID_MFA_CODE = '000000';

    /**
     * @var string
     */
    protected const INVALID_MFA_TYPE = 'invalid-type';

    protected ?MultiFactorAuthStorefrontApiFixtures $fixtures = null;

    public function loadFixtures(MultiFactorAuthStorefrontApiTester $I): void
    {
        /** @var \PyzTest\Glue\MultiFactorAuth\StorefrontApi\Fixtures\MultiFactorAuthStorefrontApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(MultiFactorAuthStorefrontApiFixtures::class);
        $this->fixtures = $fixtures;
    }

    public function requestGetMultiFactorAuthTypes(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        // Act
        $I->sendJsonApiGet(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPES);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeJsonApiResponseDataContainsResourceCollectionOfType(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPES);
    }

    public function requestActivateMultiFactorAuthType(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        // Act
        $this->activateMultiFactorAuth($I);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);

        $this->deactivateMultiFactorAuth($I);
    }

    public function requestActivateMultiFactorAuthTypeWithInvalidType(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        // Act
        $requestPayload = [
            'data' => [
                'type' => MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_ACTIVATE,
                'attributes' => [
                    'type' => static::INVALID_MFA_TYPE,
                ],
            ],
        ];
        $I->sendJsonApiPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_ACTIVATE), $requestPayload);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    public function requestVerifyMultiFactorAuthType(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        // Act
        $this->activateMultiFactorAuth($I);
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);

        $this->verifyMultiFactorAuth($I);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);

        $this->deactivateMultiFactorAuth($I);
    }

    public function requestVerifyMultiFactorAuthTypeWithoutActivation(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        // Act
        $this->verifyMultiFactorAuth($I);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    public function requestVerifyMultiFactorAuthTypeWithInvalidCode(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);

        // Act
        $I->haveHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE, static::INVALID_MFA_CODE);
        $requestPayload = $this->fixtures->createRequestPayload(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_VERIFY);
        $I->sendJsonApiPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_VERIFY), $requestPayload);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    public function requestDeactivateMultiFactorAuthType(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);

        $this->verifyMultiFactorAuth($I);
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);

        $this->deactivateMultiFactorAuth($I);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);
    }

    public function requestDeactivateMultiFactorAuthTypeWithoutActivation(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        // Act
        $this->deactivateMultiFactorAuth($I);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    public function requestDeactivateMultiFactorAuthTypeWithInvalidCode(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);

        $this->verifyMultiFactorAuth($I);
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);

        // Act
        $I->haveHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE, static::INVALID_MFA_CODE);
        $requestPayload = $this->fixtures->createRequestPayload(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_DEACTIVATE);
        $I->sendJsonApiPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_DEACTIVATE), $requestPayload);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    public function requestDeactivateMultiFactorAuthTypeWithoutVerification(MultiFactorAuthStorefrontApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeJsonApiResponseCodeIs(HttpCode::NO_CONTENT);

        // Act
        $this->deactivateMultiFactorAuth($I);

        // Assert
        $I->seeJsonApiResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();

        $I->authorizeCustomerToStorefrontApi($this->fixtures->getCustomerTransfer());
        $this->verifyMultiFactorAuth($I);

        $this->deactivateMultiFactorAuth($I);
    }

    protected function activateMultiFactorAuth(MultiFactorAuthStorefrontApiTester $I): void
    {
        $requestPayload = $this->fixtures->createRequestPayload(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_ACTIVATE);
        $I->sendJsonApiPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_ACTIVATE), $requestPayload);
    }

    protected function verifyMultiFactorAuth(MultiFactorAuthStorefrontApiTester $I): void
    {
        $this->mfaCode = $I->getCustomerMultiFactorAuthCodeFromDatabase(
            $this->fixtures->getCustomerTransfer(),
            'email',
        );

        $I->comment(sprintf('Using MFA code from database: %s', $this->mfaCode));

        $requestPayload = $this->fixtures->createRequestPayload(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_VERIFY);
        $I->haveHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE, $this->mfaCode);
        $I->sendJsonApiPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_VERIFY), $requestPayload);
    }

    protected function deactivateMultiFactorAuth(MultiFactorAuthStorefrontApiTester $I): void
    {
        if ($this->mfaCode === null) {
            $this->mfaCode = $I->getCustomerMultiFactorAuthCodeFromDatabase(
                $this->fixtures->getCustomerTransfer(),
                'email',
            );
            $I->comment(sprintf('Using MFA code from database for deactivation: %s', $this->mfaCode));
        }

        $I->haveHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE, $this->mfaCode);
        $requestPayload = $this->fixtures->createRequestPayload(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_DEACTIVATE);
        $I->sendJsonApiPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_DEACTIVATE), $requestPayload);
    }
}
