<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\MultiFactorAuth\RestApi;

use Codeception\Util\HttpCode;
use PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester;
use PyzTest\Glue\MultiFactorAuth\RestApi\Fixtures\MultiFactorAuthRestApiFixtures;
use Spryker\Glue\MultiFactorAuth\MultiFactorAuthConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group MultiFactorAuth
 * @group RestApi
 * @group MultiFactorAuthRestApiCest
 * Add your own group annotations below this line
 */
class MultiFactorAuthRestApiCest
{
    /**
     * @var string
     */
    protected const RESOURCE_MULTI_FACTOR_AUTH_TYPES = 'multi-factor-auth-types';

    /**
     * @var string|null
     */
    protected ?string $mfaCode = null;

    /**
     * @var string
     */
    protected const INVALID_MFA_CODE = '000000';

    /**
     * @var string
     */
    protected const INVALID_MFA_TYPE = 'invalid-type';

    /**
     * @var \PyzTest\Glue\MultiFactorAuth\RestApi\Fixtures\MultiFactorAuthRestApiFixtures|null
     */
    protected ?MultiFactorAuthRestApiFixtures $fixtures = null;

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function loadFixtures(MultiFactorAuthRestApiTester $I): void
    {
        /** @var \PyzTest\Glue\MultiFactorAuth\RestApi\Fixtures\MultiFactorAuthRestApiFixtures $fixtures */
        $fixtures = $I->loadFixtures(MultiFactorAuthRestApiFixtures::class);
        $this->fixtures = $fixtures;
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestGetMultiFactorAuthTypes(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        // Act
        $I->sendGet(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPES);

        // Assert
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseDataContainsResourceCollectionOfType(static::RESOURCE_MULTI_FACTOR_AUTH_TYPES);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestActivateMultiFactorAuthType(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        // Act
        $this->activateMultiFactorAuth($I);

        // Assert
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestActivateMultiFactorAuthTypeWithInvalidType(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        // Act
        $requestPayload = [
            'data' => [
                'type' => MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_ACTIVATE,
                'attributes' => [
                    'type' => static::INVALID_MFA_TYPE,
                ],
            ],
        ];
        $I->sendPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_ACTIVATE), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestVerifyMultiFactorAuthType(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        // Act
        $this->activateMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $this->verifyMultiFactorAuth($I);

        // Assert
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestVerifyMultiFactorAuthTypeWithoutActivation(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        // Act
        $this->verifyMultiFactorAuth($I);

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestVerifyMultiFactorAuthTypeWithInvalidCode(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        // Act
        $I->haveHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE, static::INVALID_MFA_CODE);
        $requestPayload = $this->fixtures->createRequestPayload(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_VERIFY);
        $I->sendPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_VERIFY), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestDeactivateMultiFactorAuthType(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $this->verifyMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $this->deactivateMultiFactorAuth($I);

        // Assert
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestDeactivateMultiFactorAuthTypeWithoutActivation(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        // Act
        $this->deactivateMultiFactorAuth($I);

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestDeactivateMultiFactorAuthTypeWithInvalidCode(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $this->verifyMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        // Act
        $I->haveHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE, static::INVALID_MFA_CODE);
        $requestPayload = $this->fixtures->createRequestPayload(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_DEACTIVATE);
        $I->sendPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_DEACTIVATE), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestDeactivateMultiFactorAuthTypeWithoutVerification(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        // Act
        $this->deactivateMultiFactorAuth($I);

        // Assert
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();

        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());
        $this->verifyMultiFactorAuth($I);

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestCreateCartWithActivatedMultiFactorAuth(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $this->verifyMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $I->haveHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE, $this->mfaCode);
        $requestPayload = $this->fixtures->createCartRequestPayload();

        // Act
        $I->sendPost($this->fixtures->generateCartUrl(), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestCreateCartWithActivatedMultiFactorAuthButInvalidCode(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $this->verifyMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $I->haveHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE, static::INVALID_MFA_CODE);
        $requestPayload = $this->fixtures->createCartRequestPayload();

        // Act
        $I->sendPost($this->fixtures->generateCartUrl(), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    public function requestCreateCartWithActivatedMultiFactorAuthWithoutCode(MultiFactorAuthRestApiTester $I): void
    {
        // Arrange
        $I->authorizeCustomerToGlue($this->fixtures->getCustomerTransfer());

        $this->activateMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $this->verifyMultiFactorAuth($I);
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);

        $I->unsetHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE);
        $requestPayload = $this->fixtures->createCartRequestPayload();

        // Act
        $I->sendPost($this->fixtures->generateCartUrl(), $requestPayload);

        // Assert
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseIsJson();
        $I->seeResponseContains(MultiFactorAuthConfig::ERROR_MESSAGE_MULTI_FACTOR_AUTH_CODE_MISSING);

        $this->deactivateMultiFactorAuth($I);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    protected function activateMultiFactorAuth(MultiFactorAuthRestApiTester $I): void
    {
        $requestPayload = $this->fixtures->createRequestPayload(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_ACTIVATE);
        $I->sendPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_ACTIVATE), $requestPayload);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    protected function verifyMultiFactorAuth(MultiFactorAuthRestApiTester $I): void
    {
        $this->mfaCode = $I->getCustomerMultiFactorAuthCodeFromDatabase(
            $this->fixtures->getCustomerTransfer(),
            'email',
        );

        $I->comment(sprintf('Using MFA code from database: %s', $this->mfaCode));

        $requestPayload = $this->fixtures->createRequestPayload(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_VERIFY);
        $I->haveHttpHeader(MultiFactorAuthConfig::HEADER_MULTI_FACTOR_AUTH_CODE, $this->mfaCode);
        $I->sendPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_VERIFY), $requestPayload);
    }

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return void
     */
    protected function deactivateMultiFactorAuth(MultiFactorAuthRestApiTester $I): void
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
        $I->sendPost($this->fixtures->generateUrl(MultiFactorAuthConfig::RESOURCE_MULTI_FACTOR_AUTH_TYPE_DEACTIVATE), $requestPayload);
    }
}
