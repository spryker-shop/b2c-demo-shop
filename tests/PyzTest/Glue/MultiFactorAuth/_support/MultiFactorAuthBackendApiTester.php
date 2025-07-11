<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\MultiFactorAuth;

use Generated\Shared\Transfer\UserTransfer;
use Orm\Zed\MultiFactorAuth\Persistence\Map\SpyUserMultiFactorAuthCodesTableMap;
use Orm\Zed\MultiFactorAuth\Persistence\SpyUserMultiFactorAuthCodesQuery;
use SprykerTest\Glue\Testify\Tester\BackendApiEndToEndTester;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
 */
class MultiFactorAuthBackendApiTester extends BackendApiEndToEndTester
{
    use _generated\MultiFactorAuthBackendApiTesterActions;

    /**
     * @var string
     */
    public const TEST_UUID = '11111111-55a9-55ae-a538-4d8109b4087c';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'Change!23456';

    /**
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     *
     * @return void
     */
    public function authorizeUserToBackendApi(UserTransfer $userTransfer): void
    {
        $oauthResponseTransfer = $this->havePasswordAuthorizationToBackendApi($userTransfer);
        $this->amBearerAuthenticated($oauthResponseTransfer->getAccessToken());
    }

    /**
     * @param string $userName
     *
     * @return \Generated\Shared\Transfer\UserTransfer
     */
    public function createUser(string $userName): UserTransfer
    {
        $userTransfer = $this->haveUser([
            UserTransfer::USERNAME => $userName,
            UserTransfer::PASSWORD => static::TEST_PASSWORD,
            UserTransfer::UUID => static::TEST_UUID,
        ]);

        return $userTransfer->setPassword(static::TEST_PASSWORD);
    }

    /**
     * @param \Generated\Shared\Transfer\UserTransfer $userTransfer
     * @param string $mfaType
     *
     * @return string|null
     */
    public function getUserMultiFactorAuthCodeFromDatabase(UserTransfer $userTransfer, string $mfaType): ?string
    {
        $userMultiFactorAuthCodeEntity = (new SpyUserMultiFactorAuthCodesQuery())
            ->innerJoinSpyUserMultiFactorAuth()
            ->useSpyUserMultiFactorAuthQuery()
            ->filterByType($mfaType);

        /** @var \Orm\Zed\MultiFactorAuth\Persistence\SpyUserMultiFactorAuthCodes|null $userMultiFactorAuthCodeEntity */
        $userMultiFactorAuthCodeEntity = $userMultiFactorAuthCodeEntity->filterByFkUser($userTransfer->getIdUser())
            ->addDescendingOrderByColumn(SpyUserMultiFactorAuthCodesTableMap::COL_ID_USER_MULTI_FACTOR_AUTH_CODE)
            ->endUse()
            ->findOne();

        return $userMultiFactorAuthCodeEntity?->getCode();
    }
}
