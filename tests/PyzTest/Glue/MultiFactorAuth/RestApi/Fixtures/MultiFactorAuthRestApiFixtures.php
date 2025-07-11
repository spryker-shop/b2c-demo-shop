<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\MultiFactorAuth\RestApi\Fixtures;

use Generated\Shared\Transfer\CustomerTransfer;
use PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

class MultiFactorAuthRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'MultiFactorAuthRestApiFixtures';

    /**
     * @var string
     */
    protected const MFA_TYPE = 'email';

    /**
     * @var string
     */
    protected const RESOURCE_CARTS = 'carts';

    /**
     * @var \Generated\Shared\Transfer\CustomerTransfer
     */
    protected CustomerTransfer $customerTransfer;

    /**
     * @param \PyzTest\Glue\MultiFactorAuth\MultiFactorAuthRestApiTester $I
     *
     * @return \SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface
     */
    public function buildFixtures(MultiFactorAuthRestApiTester $I): FixturesContainerInterface
    {
        $this->customerTransfer = $I->createCustomer(static::TEST_USERNAME);

        return $this;
    }

    /**
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
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
    public function createCartRequestPayload(): array
    {
        return [
            'data' => [
                'type' => static::RESOURCE_CARTS,
                'attributes' => [
                    'name' => 'Test Cart',
                    'priceMode' => 'GROSS_MODE',
                    'currency' => 'EUR',
                    'store' => 'DE',
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
    public function generateCartUrl(): string
    {
        return sprintf('/%s', static::RESOURCE_CARTS);
    }
}
