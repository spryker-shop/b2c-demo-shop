<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport;

use Spryker\Zed\DataImport\DataImportConfig as SprykerDataImportConfig;
use Spryker\Zed\StockAddressDataImport\StockAddressDataImportConfig;

/**
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class DataImportConfig extends SprykerDataImportConfig
{
    /**
     * @var string
     */
    public const IMPORT_TYPE_CATEGORY_TEMPLATE = 'category-template';

    /**
     * @var string
     */
    public const IMPORT_TYPE_CUSTOMER = 'customer';

    /**
     * @var string
     */
    public const IMPORT_TYPE_GLOSSARY = 'glossary';

    /**
     * @var string
     */
    public const IMPORT_TYPE_NAVIGATION = 'navigation';

    /**
     * @var string
     */
    public const IMPORT_TYPE_NAVIGATION_NODE = 'navigation-node';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_STOCK = 'product-stock';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_ABSTRACT = 'product-abstract';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_ABSTRACT_STORE = 'product-abstract-store';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_CONCRETE = 'product-concrete';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_ATTRIBUTE_KEY = 'product-attribute-key';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_MANAGEMENT_ATTRIBUTE = 'product-management-attribute';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_REVIEW = 'product-review';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_SET = 'product-set';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_GROUP = 'product-group';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_OPTION = 'product-option';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_OPTION_PRICE = 'product-option-price';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_IMAGE = 'product-image';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_SEARCH_ATTRIBUTE_MAP = 'product-search-attribute-map';

    /**
     * @var string
     */
    public const IMPORT_TYPE_PRODUCT_SEARCH_ATTRIBUTE = 'product-search-attribute';

    /**
     * @var string
     */
    public const IMPORT_TYPE_CMS_TEMPLATE = 'cms-template';

    /**
     * @var string
     */
    public const IMPORT_TYPE_CMS_BLOCK = 'cms-block';

    /**
     * @var string
     */
    public const IMPORT_TYPE_CMS_BLOCK_STORE = 'cms-block-store';

    /**
     * @var string
     */
    public const IMPORT_TYPE_DISCOUNT = 'discount';

    /**
     * @var string
     */
    public const IMPORT_TYPE_DISCOUNT_STORE = 'discount-store';

    /**
     * @var string
     */
    public const IMPORT_TYPE_DISCOUNT_AMOUNT = 'discount-amount';

    /**
     * @var string
     */
    public const IMPORT_TYPE_DISCOUNT_VOUCHER = 'discount-voucher';

    /**
     * @var string
     */
    public const IMPORT_TYPE_TAX = 'tax';

    /**
     * @var string
     */
    public const IMPORT_TYPE_CURRENCY = 'currency';

    /**
     * @var string
     */
    public const IMPORT_TYPE_STORE = 'store';

    /**
     * @var string
     */
    public const IMPORT_TYPE_ABSTRACT_GIFT_CARD_CONFIGURATION = 'gift-card-abstract-configuration';

    /**
     * @var string
     */
    public const IMPORT_TYPE_CONCRETE_GIFT_CARD_CONFIGURATION = 'gift-card-concrete-configuration';

    /**
     * @var string
     */
    public const IMPORT_TYPE_COMBINED_PRODUCT_ABSTRACT = 'combined-product-abstract';

    /**
     * @var string
     */
    public const IMPORT_TYPE_COMBINED_PRODUCT_ABSTRACT_STORE = 'combined-product-abstract-store';

    /**
     * @var string
     */
    public const IMPORT_TYPE_COMBINED_PRODUCT_CONCRETE = 'combined-product-concrete';

    /**
     * @var string
     */
    public const IMPORT_TYPE_COMBINED_PRODUCT_IMAGE = 'combined-product-image';

    /**
     * @var string
     */
    public const IMPORT_TYPE_COMBINED_PRODUCT_PRICE = 'combined-product-price';

    /**
     * @var string
     */
    public const IMPORT_TYPE_COMBINED_PRODUCT_STOCK = 'combined-product-stock';

    /**
     * @var string
     */
    public const IMPORT_TYPE_COMBINED_PRODUCT_GROUP = 'combined-product-group';

    /**
     * @var int
     */
    protected const READ_COLLECTION_BATCH_SIZE = 500;

    /**
     * @return string|null
     */
    public function getDefaultYamlConfigPath(): ?string
    {
        $regionDir = defined('APPLICATION_REGION') ? APPLICATION_REGION : 'EU';

        return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . 'data/import/local/full_' . $regionDir . '.yml';
    }

    /**
     * @return array<string>
     */
    public function getFullImportTypes(): array
    {
        $customImportTypes = [
            StockAddressDataImportConfig::IMPORT_TYPE_STOCK_ADDRESS,
        ];

        return array_merge(parent::getFullImportTypes(), $customImportTypes);
    }

    /**
     * @return int
     */
    public function getReadCollectionBatchSize(): int
    {
        return static::READ_COLLECTION_BATCH_SIZE;
    }
}
