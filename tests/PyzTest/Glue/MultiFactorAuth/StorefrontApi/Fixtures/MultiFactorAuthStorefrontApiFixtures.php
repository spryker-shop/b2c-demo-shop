<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\MultiFactorAuth\StorefrontApi\Fixtures;

use Generated\Shared\Transfer\CustomerTransfer;
use PyzTest\Glue\MultiFactorAuth\MultiFactorAuthStorefrontApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class MultiFactorAuthStorefrontApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_CUSTOMER_NAME = 'multiFactorAuthStorefrontApiCustomer@example.com';

    /**
     * @var string
     */
    protected const MFA_TYPE = 'email';

    protected CustomerTransfer $customerTransfer;

    public function buildFixtures(MultiFactorAuthStorefrontApiTester $I): FixturesContainerInterface
    {
        $this->customerTransfer = $I->createCustomer(static::TEST_CUSTOMER_NAME);

        return $this;
    }

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    /**
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

    public function generateUrl(string $resourceName): string
    {
        return sprintf('/%s', $resourceName);
    }
}
