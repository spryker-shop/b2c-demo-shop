<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Glue\ProductConfigurations;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ProductConfigurationTransfer;
use Generated\Shared\Transfer\RestProductConfigurationInstanceAttributesTransfer;
use SprykerTest\Glue\Testify\Tester\ApiEndToEndTester;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(\PyzTest\Glue\ProductConfigurations\PHPMD)
 */
class ProductConfigurationsApiTester extends ApiEndToEndTester
{
    use _generated\ProductConfigurationsApiTesterActions;

    /**
     * @var string
     */
    protected const ATTRIBUTE_KEY_SKU = 'sku';

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return void
     */
    public function amAuthorizedCustomer(CustomerTransfer $customerTransfer): void
    {
        $token = $this->haveAuthorizationToGlue($customerTransfer)->getAccessTokenOrFail();

        $this->amBearerAuthenticated($token);
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConfigurationTransfer $productConfigurationTransfer
     *
     * @return void
     */
    public function seeProductConfigurationInstanceEqualToExpectedValue(ProductConfigurationTransfer $productConfigurationTransfer): void
    {
        $productConfigurationData = $this->grabProductConfigurationInstanceDataFromConcreteProductsResource();
        $restProductConfigurationInstanceAttributesTransfer = $this->mapProductConfigurationTransferToRestProductConfigurationInstanceAttributesTransfer(
            $productConfigurationTransfer,
            new RestProductConfigurationInstanceAttributesTransfer(),
        );

        $this->assertEqualsCanonicalizing(
            $productConfigurationData,
            $restProductConfigurationInstanceAttributesTransfer->toArray(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConfigurationTransfer $productConfigurationTransfer
     *
     * @return void
     */
    public function seeOrderItemContainProductConfigurationInstance(ProductConfigurationTransfer $productConfigurationTransfer): void
    {
        $productConfigurationData = $this->grabProductConfigurationInstanceDataFromOrdersResource();
        $restProductConfigurationInstanceAttributesTransfer = $this->mapProductConfigurationTransferToRestProductConfigurationInstanceAttributesTransfer(
            $productConfigurationTransfer,
            new RestProductConfigurationInstanceAttributesTransfer(),
        );

        $this->assertEquals($productConfigurationData['displayData'], $restProductConfigurationInstanceAttributesTransfer->getDisplayData());
        $this->assertEquals($productConfigurationData['configuration'], $restProductConfigurationInstanceAttributesTransfer->getConfiguration());
        $this->assertEquals($productConfigurationData['configuratorKey'], $restProductConfigurationInstanceAttributesTransfer->getConfiguratorKey());
    }

    /**
     * @param string $resourceName
     * @param string $itemSku
     *
     * @return void
     */
    public function seeCartItemContainsProductConfigurationInstance(
        string $resourceName,
        string $itemSku,
    ): void {
        $includedByTypeAndSku = $this->grabIncludedByTypeAndSku($resourceName, $itemSku);

        $this->assertArrayHasKey('productConfigurationInstance', $includedByTypeAndSku);
    }

    /**
     * @param string $resourceName
     * @param string $sku
     *
     * @return array<string, mixed>
     */
    public function grabIncludedByTypeAndSku(string $resourceName, string $sku): array
    {
        $jsonPath = sprintf(
            '$..included[?(@.type == \'%s\')].attributes',
            $resourceName,
        );

        $attributes = $this->grabDataFromResponseByJsonPath($jsonPath);
        foreach ($attributes as $attribute) {
            if ($attribute[static::ATTRIBUTE_KEY_SKU] === $sku) {
                return $attribute;
            }
        }

        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function grabProductConfigurationInstanceDataFromConcreteProductsResource(): array
    {
        return $this->getDataFromResponseByJsonPath('$.data.attributes.productConfigurationInstance');
    }

    /**
     * @return array<string, mixed>
     */
    protected function grabProductConfigurationInstanceDataFromOrdersResource(): array
    {
        return $this->getDataFromResponseByJsonPath('$.data.attributes.items[0].salesOrderItemConfiguration');
    }

    /**
     * @param \Generated\Shared\Transfer\ProductConfigurationTransfer $productConfigurationTransfer
     * @param \Generated\Shared\Transfer\RestProductConfigurationInstanceAttributesTransfer $restProductConfigurationInstanceAttributesTransfer
     *
     * @return \Generated\Shared\Transfer\RestProductConfigurationInstanceAttributesTransfer
     */
    protected function mapProductConfigurationTransferToRestProductConfigurationInstanceAttributesTransfer(
        ProductConfigurationTransfer $productConfigurationTransfer,
        RestProductConfigurationInstanceAttributesTransfer $restProductConfigurationInstanceAttributesTransfer,
    ): RestProductConfigurationInstanceAttributesTransfer {
        $restProductConfigurationInstanceAttributesTransfer = $restProductConfigurationInstanceAttributesTransfer->fromArray(
            $productConfigurationTransfer->toArray(),
            true,
        );

        $restProductConfigurationInstanceAttributesTransfer->setDisplayData($productConfigurationTransfer->getDefaultDisplayData());
        $restProductConfigurationInstanceAttributesTransfer->setConfiguration($productConfigurationTransfer->getDefaultConfiguration());

        return $restProductConfigurationInstanceAttributesTransfer;
    }
}
