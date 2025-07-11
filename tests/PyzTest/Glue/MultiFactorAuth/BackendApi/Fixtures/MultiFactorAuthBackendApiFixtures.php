<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\MultiFactorAuth\BackendApi\Fixtures;

use Generated\Shared\Transfer\UserTransfer;
use PyzTest\Glue\MultiFactorAuth\MultiFactorAuthBackendApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class MultiFactorAuthBackendApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USER_NAME = 'multiFactorAuthBackendApiUser@example.com';

    /**
     * @var string
     */
    protected const MFA_TYPE = 'email';

    /**
     * @var string
     */
    protected const RESOURCE_WAREHOUSE_USER_ASSIGNMENTS = 'warehouse-user-assignments';

    /**
     * @var \Generated\Shared\Transfer\UserTransfer
     */
    protected UserTransfer $userTransfer;

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthBackendApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(MultiFactorAuthBackendApiTester $I): FixturesContainerInterface
    {
        $this->userTransfer = $I->createUser(static::TEST_USER_NAME);

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
     * @param string $resourceType
     *
     * @return array<string, mixed>
     */
    public function createRequestPayload(string $resourceType): array
    {
        return [
            'data' => [
                'type' => $resourceType,
                'attributes' => [
                    'type' => static::MFA_TYPE,
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function createWarehouseUserAssignmentsRequestPayload(): array
    {
        return [
            'data' => [
                'type' => static::RESOURCE_WAREHOUSE_USER_ASSIGNMENTS,
                'attributes' => [
                    'userUuid' => 'test',
                    'warehouse' => [
                        'uuid' => 'test',
                    ],
                    'isActive' => 'false',
                ],
            ],
        ];
    }

    /**
     * @param string $resourceName
     *
     * @return string
     */
    public function generateUrl(string $resourceName): string
    {
        return sprintf('/%s', $resourceName);
    }

    /**
     * @return string
     */
    public function generateWarehouseUserAssignmentsUrl(): string
    {
        return sprintf('/%s', static::RESOURCE_WAREHOUSE_USER_ASSIGNMENTS);
    }
}
