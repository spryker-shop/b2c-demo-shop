<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business;

use Generated\Shared\Transfer\DataImportConfigurationActionTransfer;
use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Pyz\Zed\DataImport\Business\CombinedProduct\Product\CombinedAttributesExtractorStep;
use Pyz\Zed\DataImport\Business\CombinedProduct\Product\CombinedProductLocalizedAttributesExtractorStep;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductAbstract\CombinedProductAbstractHydratorStep;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductAbstract\CombinedProductAbstractTypeDataSetCondition;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductAbstract\Writer\CombinedProductAbstractPropelDataSetWriter;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductAbstractStore\CombinedProductAbstractStoreHydratorStep;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductAbstractStore\CombinedProductAbstractStoreMandatoryColumnCondition;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductAbstractStore\Writer\CombinedProductAbstractStorePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductConcrete\CombinedProductConcreteHydratorStep;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductConcrete\CombinedProductConcreteTypeDataSetCondition;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductConcrete\Writer\CombinedProductConcretePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductGroup\CombinedProductGroupMandatoryColumnCondition;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductGroup\CombinedProductGroupWriter;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductImage\CombinedProductImageHydratorStep;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductImage\CombinedProductImageMandatoryColumnCondition;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductImage\Writer\CombinedProductImagePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductPrice\CombinedProductPriceHydratorStep;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductPrice\CombinedProductPriceMandatoryColumnCondition;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductPrice\Writer\CombinedProductPricePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductStock\CombinedProductStockHydratorStep;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductStock\CombinedProductStockMandatoryColumnCondition;
use Pyz\Zed\DataImport\Business\CombinedProduct\ProductStock\Writer\CombinedProductStockPropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\CategoryTemplate\CategoryTemplateWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsBlock\CmsBlockWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsBlockStore\CmsBlockStoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsTemplate\CmsTemplateWriterStep;
use Pyz\Zed\DataImport\Business\Model\Country\Repository\CountryRepository;
use Pyz\Zed\DataImport\Business\Model\Currency\CurrencyWriterStep;
use Pyz\Zed\DataImport\Business\Model\Customer\CustomerWriterStep;
use Pyz\Zed\DataImport\Business\Model\DataImporterConditional;
use Pyz\Zed\DataImport\Business\Model\DataImporterDataSetWriterAwareConditional;
use Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface;
use Pyz\Zed\DataImport\Business\Model\Discount\DiscountWriterStep;
use Pyz\Zed\DataImport\Business\Model\DiscountAmount\DiscountAmountWriterStep;
use Pyz\Zed\DataImport\Business\Model\DiscountStore\DiscountStoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\DiscountVoucher\DiscountVoucherWriterStep;
use Pyz\Zed\DataImport\Business\Model\GiftCard\GiftCardAbstractConfigurationWriterStep;
use Pyz\Zed\DataImport\Business\Model\GiftCard\GiftCardConcreteConfigurationWriterStep;
use Pyz\Zed\DataImport\Business\Model\Glossary\GlossaryWriterStep;
use Pyz\Zed\DataImport\Business\Model\Locale\AddLocalesStep;
use Pyz\Zed\DataImport\Business\Model\Locale\LocaleNameToIdLocaleStep;
use Pyz\Zed\DataImport\Business\Model\Locale\Repository\LocaleRepository;
use Pyz\Zed\DataImport\Business\Model\Navigation\NavigationKeyToIdNavigationStep;
use Pyz\Zed\DataImport\Business\Model\Navigation\NavigationWriterStep;
use Pyz\Zed\DataImport\Business\Model\NavigationNode\NavigationNodeValidityDatesStep;
use Pyz\Zed\DataImport\Business\Model\NavigationNode\NavigationNodeWriterStep;
use Pyz\Zed\DataImport\Business\Model\Product\AttributesExtractorStep;
use Pyz\Zed\DataImport\Business\Model\Product\ProductLocalizedAttributesExtractorStep;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\AddCategoryKeysStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\AddProductAbstractSkusStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractCheckExistenceStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractSkuToIdProductAbstractStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\Writer\ProductAbstractPropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\ProductAbstractStoreHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\Writer\ProductAbstractStorePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\AddProductAttributeKeysStep;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\ProductAttributeKeyWriter;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteAttributesUniqueCheckStep;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteCheckExistenceStep;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductSkuToIdProductStep;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\Writer\ProductConcretePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductGroup\ProductGroupWriter;
use Pyz\Zed\DataImport\Business\Model\ProductImage\ProductImageHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductImage\Repository\ProductImageRepository;
use Pyz\Zed\DataImport\Business\Model\ProductImage\Repository\ProductImageRepositoryInterface;
use Pyz\Zed\DataImport\Business\Model\ProductImage\Writer\ProductImagePropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\ProductManagementAttribute\ProductManagementAttributeWriter;
use Pyz\Zed\DataImport\Business\Model\ProductManagementAttribute\ProductManagementLocalizedAttributesExtractorStep;
use Pyz\Zed\DataImport\Business\Model\ProductOption\ProductOptionWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductOptionPrice\ProductOptionPriceWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductReview\ProductReviewWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductSearchAttribute\Hook\ProductSearchAfterImportHook;
use Pyz\Zed\DataImport\Business\Model\ProductSearchAttribute\ProductSearchAttributeWriter;
use Pyz\Zed\DataImport\Business\Model\ProductSearchAttributeMap\ProductSearchAttributeMapWriter;
use Pyz\Zed\DataImport\Business\Model\ProductSet\ProductSetImageExtractorStep;
use Pyz\Zed\DataImport\Business\Model\ProductSet\ProductSetWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Hook\ProductStockAfterImportPublishHook;
use Pyz\Zed\DataImport\Business\Model\ProductStock\ProductStockHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\ProductStockPropelDataSetWriter;
use Pyz\Zed\DataImport\Business\Model\Store\StoreReader;
use Pyz\Zed\DataImport\Business\Model\Store\StoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\Tax\TaxSetNameToIdTaxSetStep;
use Pyz\Zed\DataImport\Business\Model\Tax\TaxWriterStep;
use Pyz\Zed\DataImport\Communication\Plugin\CombinedProduct\ProductAbstract\CombinedProductAbstractPropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\CombinedProduct\ProductAbstractStore\CombinedProductAbstractStorePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\CombinedProduct\ProductConcrete\CombinedProductConcretePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\CombinedProduct\ProductImage\CombinedProductImagePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\CombinedProduct\ProductPrice\CombinedProductPricePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\CombinedProduct\ProductStock\CombinedProductStockPropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductAbstract\ProductAbstractPropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductAbstractStore\ProductAbstractStorePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductConcrete\ProductConcretePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductImage\ProductImagePropelWriterPlugin;
use Pyz\Zed\DataImport\Communication\Plugin\ProductStock\ProductStockPropelWriterPlugin;
use Pyz\Zed\DataImport\DataImportConfig;
use Pyz\Zed\DataImport\DataImportDependencyProvider;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\ProductSearch\Code\KeyBuilder\FilterGlossaryKeyBuilder;
use Spryker\Zed\Currency\Business\CurrencyFacadeInterface;
use Spryker\Zed\DataImport\Business\DataImportBusinessFactory as SprykerDataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataReader\DataReaderInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterCollection;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface;
use Spryker\Zed\Discount\DiscountConfig;
use Spryker\Zed\PriceProduct\Business\PriceProductFacadeInterface;
use Spryker\Zed\Stock\Business\StockFacadeInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * @method \Pyz\Zed\DataImport\DataImportConfig getConfig()
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class DataImportBusinessFactory extends SprykerDataImportBusinessFactory
{
    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|null
     */
    public function getDataImporterByType(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer): ?DataImporterInterface
    {
        switch ($dataImportConfigurationActionTransfer->getDataEntity()) {
            case DataImportConfig::IMPORT_TYPE_STORE:
                return $this->createStoreImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_CURRENCY:
                return $this->createCurrencyImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_CATEGORY_TEMPLATE:
                return $this->createCategoryTemplateImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_CUSTOMER:
                return $this->createCustomerImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_GLOSSARY:
                return $this->createGlossaryImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_TAX:
                return $this->createTaxImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_DISCOUNT:
                return $this->createDiscountImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_DISCOUNT_STORE:
                return $this->createDiscountStoreImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_DISCOUNT_VOUCHER:
                return $this->createDiscountVoucherImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_ATTRIBUTE_KEY:
                return $this->createProductAttributeKeyImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_MANAGEMENT_ATTRIBUTE:
                return $this->createProductManagementAttributeImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_ABSTRACT:
                return $this->createProductAbstractImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_ABSTRACT_STORE:
                return $this->createProductAbstractStoreImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_CONCRETE:
                return $this->createProductConcreteImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_IMAGE:
                return $this->createProductImageImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_OPTION:
                return $this->createProductOptionImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_OPTION_PRICE:
                return $this->createProductOptionPriceImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_GROUP:
                return $this->createProductGroupImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_COMBINED_PRODUCT_ABSTRACT:
                return $this->createCombinedProductAbstractImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_COMBINED_PRODUCT_ABSTRACT_STORE:
                return $this->createCombinedProductAbstractStoreImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_COMBINED_PRODUCT_CONCRETE:
                return $this->createCombinedProductConcreteImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_COMBINED_PRODUCT_IMAGE:
                return $this->createCombinedProductImageImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_COMBINED_PRODUCT_PRICE:
                return $this->createCombinedProductPriceImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_COMBINED_PRODUCT_STOCK:
                return $this->createCombinedProductStockImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_COMBINED_PRODUCT_GROUP:
                return $this->createCombinedProductGroupImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_REVIEW:
                return $this->createProductReviewImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_SET:
                return $this->createProductSetImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_SEARCH_ATTRIBUTE_MAP:
                return $this->createProductSearchAttributeMapImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_SEARCH_ATTRIBUTE:
                return $this->createProductSearchAttributeImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_CMS_TEMPLATE:
                return $this->createCmsTemplateImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_CMS_BLOCK:
                return $this->createCmsBlockImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_CMS_BLOCK_STORE:
                return $this->createCmsBlockStoreImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_DISCOUNT_AMOUNT:
                return $this->createDiscountAmountImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_ABSTRACT_GIFT_CARD_CONFIGURATION:
                return $this->createAbstractGiftCardConfigurationImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_CONCRETE_GIFT_CARD_CONFIGURATION:
                return $this->createConcreteGiftCardConfigurationImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_STOCK:
                return $this->createProductStockImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_NAVIGATION:
                return $this->createNavigationImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_NAVIGATION_NODE:
                return $this->createNavigationNodeImporter($dataImportConfigurationActionTransfer);
            default:
                return null;
        }
    }

    /**
     * @param string $importType
     * @param \Spryker\Zed\DataImport\Business\Model\DataReader\DataReaderInterface $reader
     *
     * @return \Pyz\Zed\DataImport\Business\Model\DataImporterConditional
     */
    public function createDataImporterConditional($importType, DataReaderInterface $reader)
    {
        return new DataImporterConditional($importType, $reader);
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    protected function createCurrencyImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer): DataImporterInterface
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep(new CurrencyWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    protected function createStoreImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer): DataImporterInterface
    {
        /** @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterInterface $dataImporter */
        $dataImporter = $this->createDataImporter(
            $dataImportConfigurationActionTransfer->getDataEntity(),
            new StoreReader(
                $this->createDataSet(
                    Store::getInstance()->getAllowedStores()
                )
            )
        );

        $dataSetStepBroker = $this->createDataSetStepBroker();
        $dataSetStepBroker->addStep(new StoreWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    protected function createGlossaryImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer): DataImporterInterface
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(GlossaryWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createLocaleNameToIdStep(GlossaryWriterStep::KEY_LOCALE))
            ->addStep(new GlossaryWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    protected function createCategoryTemplateImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer): DataImporterInterface
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep(new CategoryTemplateWriterStep());

        $dataImporter
            ->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createCustomerImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep(new CustomerWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createCmsTemplateImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep(new CmsTemplateWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createCmsBlockImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(CmsBlockWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createLocalizedAttributesExtractorStep([
                CmsBlockWriterStep::KEY_PLACEHOLDER_TITLE,
                CmsBlockWriterStep::KEY_PLACEHOLDER_DESCRIPTION,
                CmsBlockWriterStep::KEY_PLACEHOLDER_CONTENT,
                CmsBlockWriterStep::KEY_PLACEHOLDER_LINK,
            ]))
            ->addStep(new CmsBlockWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createCmsBlockStoreImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(CmsBlockStoreWriterStep::BULK_SIZE);
        $dataSetStepBroker->addStep(new CmsBlockStoreWriterStep());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createDiscountImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(DiscountWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new DiscountWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createDiscountStoreImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );
        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(DiscountStoreWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new DiscountStoreWriterStep());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createDiscountAmountImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(DiscountAmountWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new DiscountAmountWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createDiscountVoucherImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(DiscountVoucherWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new DiscountVoucherWriterStep($this->createDiscountConfig()));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Spryker\Zed\Discount\DiscountConfig
     */
    protected function createDiscountConfig()
    {
        return new DiscountConfig();
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductOptionImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createTaxSetNameToIdTaxSetStep(ProductOptionWriterStep::KEY_TAX_SET_NAME))
            ->addStep($this->createLocalizedAttributesExtractorStep([
                ProductOptionWriterStep::KEY_GROUP_NAME,
                ProductOptionWriterStep::KEY_OPTION_NAME,
            ]))
            ->addStep(new ProductOptionWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductOptionPriceImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep(new ProductOptionPriceWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createProductStockImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        /** @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterDataSetWriterAwareInterface $dataImporter */
        $dataImporter = $this->getCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductStockHydratorStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new ProductStockHydratorStep());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createProductStockDataImportWriters());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductStock\Hook\ProductStockAfterImportPublishHook
     */
    protected function createProductStockAfterImportPublishHook()
    {
        return new ProductStockAfterImportPublishHook();
    }

    /**
     * @return \Spryker\Zed\Availability\Business\AvailabilityFacadeInterface
     */
    protected function getAvailabilityFacade()
    {
        return $this->getProvidedDependency(DataImportDependencyProvider::FACADE_AVAILABILITY);
    }

    /**
     * @return \Spryker\Zed\ProductBundle\Business\ProductBundleFacadeInterface
     */
    protected function getProductBundleFacade()
    {
        return $this->getProvidedDependency(DataImportDependencyProvider::FACADE_PRODUCT_BUNDLE);
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createProductImageImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        /** @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterDataSetWriterAwareInterface $dataImporter */
        $dataImporter = $this->getCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductImageHydratorStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createProductAbstractSkuToIdProductAbstractStep(ProductImageHydratorStep::COLUMN_ABSTRACT_SKU, ProductImageHydratorStep::KEY_IMAGE_SET_FK_PRODUCT_ABSTRACT))
            ->addStep($this->createProductSkuToIdProductStep(ProductImageHydratorStep::COLUMN_CONCRETE_SKU, ProductImageHydratorStep::KEY_IMAGE_SET_FK_PRODUCT))
            ->addStep($this->createLocaleNameToIdStep(ProductImageHydratorStep::COLUMN_LOCALE, ProductImageHydratorStep::KEY_IMAGE_SET_FK_LOCALE))
            ->addStep(new ProductImageHydratorStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createProductImageDataWriters());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\Locale\Repository\LocaleRepositoryInterface
     */
    protected function createLocaleRepository()
    {
        return new LocaleRepository();
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createTaxImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(TaxWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new TaxWriterStep($this->createCountryRepository()));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\Country\Repository\CountryRepositoryInterface
     */
    protected function createCountryRepository()
    {
        return new CountryRepository();
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createNavigationImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(NavigationWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new NavigationWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createNavigationNodeImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(NavigationNodeWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createNavigationKeyToIdNavigationStep(NavigationNodeWriterStep::KEY_NAVIGATION_KEY))
            ->addStep($this->createLocalizedAttributesExtractorStep([
                NavigationNodeWriterStep::KEY_TITLE,
                NavigationNodeWriterStep::KEY_URL,
                NavigationNodeWriterStep::KEY_CSS_CLASS,
            ]))
            ->addStep($this->createNavigationNodeValidityDatesStep(NavigationNodeWriterStep::KEY_VALID_FROM, NavigationNodeWriterStep::KEY_VALID_TO))
            ->addStep(new NavigationNodeWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param string $source
     * @param string $target
     *
     * @return \Pyz\Zed\DataImport\Business\Model\Navigation\NavigationKeyToIdNavigationStep
     */
    protected function createNavigationKeyToIdNavigationStep($source = NavigationKeyToIdNavigationStep::KEY_SOURCE, $target = NavigationKeyToIdNavigationStep::KEY_TARGET)
    {
        return new NavigationKeyToIdNavigationStep($source, $target);
    }

    /**
     * @param string $keyValidFrom
     * @param string $keyValidTo
     *
     * @return \Pyz\Zed\DataImport\Business\Model\NavigationNode\NavigationNodeValidityDatesStep
     */
    protected function createNavigationNodeValidityDatesStep($keyValidFrom, $keyValidTo)
    {
        return new NavigationNodeValidityDatesStep($keyValidFrom, $keyValidTo);
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createProductAbstractImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        /** @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterDataSetWriterAwareInterface $dataImporter */
        $dataImporter = $this->getCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductAbstractHydratorStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createProductAbstractCheckExistenceStep())
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createAddCategoryKeysStep())
            ->addStep($this->createTaxSetNameToIdTaxSetStep(ProductAbstractHydratorStep::COLUMN_TAX_SET_NAME))
            ->addStep($this->createAttributesExtractorStep())
            ->addStep($this->createProductLocalizedAttributesExtractorStep([
                ProductAbstractHydratorStep::COLUMN_NAME,
                ProductAbstractHydratorStep::COLUMN_URL,
                ProductAbstractHydratorStep::COLUMN_DESCRIPTION,
                ProductAbstractHydratorStep::COLUMN_META_TITLE,
                ProductAbstractHydratorStep::COLUMN_META_DESCRIPTION,
                ProductAbstractHydratorStep::COLUMN_META_KEYWORDS,
            ]))
            ->addStep(new ProductAbstractHydratorStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createProductAbstractDataImportWriters());

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createProductAbstractStoreImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        /** @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterDataSetWriterAwareInterface $dataImporter */
        $dataImporter = $this->getCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductAbstractStoreHydratorStep::BULK_SIZE);
        $dataSetStepBroker->addStep(new ProductAbstractStoreHydratorStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createProductAbstractStoreDataImportWriters());

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createProductConcreteImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        /** @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterBeforeImportAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterAfterImportAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterDataSetWriterAwareInterface $dataImporter */
        $dataImporter = $this->getCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductConcreteHydratorStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createProductConcreteCheckExistenceStep())
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createAttributesExtractorStep())
            ->addStep($this->createProductConcreteAttributesUniqueCheckStep())
            ->addStep($this->createProductLocalizedAttributesExtractorStep([
                ProductConcreteHydratorStep::COLUMN_NAME,
                ProductConcreteHydratorStep::COLUMN_DESCRIPTION,
                ProductConcreteHydratorStep::COLUMN_IS_SEARCHABLE,
            ]))
            ->addStep(new ProductConcreteHydratorStep(
                $this->createProductRepository()
            ));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createProductConcreteDataImportWriters());

        return $dataImporter;
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createProductConcreteAttributesUniqueCheckStep(): DataImportStepInterface
    {
        return new ProductConcreteAttributesUniqueCheckStep(
            $this->createProductRepository(),
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createProductAbstractCheckExistenceStep()
    {
        return new ProductAbstractCheckExistenceStep(
            $this->createProductRepository()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createProductConcreteCheckExistenceStep()
    {
        return new ProductConcreteCheckExistenceStep(
            $this->createProductRepository()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createProductAbstractDataImportWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createProductAbstractWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createProductAbstractWriterPlugins()
    {
        return [
            new ProductAbstractPropelWriterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createProductConcreteDataImportWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createProductConcreteWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createProductConcreteWriterPlugins()
    {
        return [
            new ProductConcretePropelWriterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createProductImageDataWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createProductImageWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createProductImageWriterPlugins()
    {
        return [
            new ProductImagePropelWriterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createProductStockDataImportWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createProductStockWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createProductStockWriterPlugins()
    {
        return [
            new ProductStockPropelWriterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createProductAbstractStoreDataImportWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createProductAbstractStoreWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createProductAbstractStoreWriterPlugins()
    {
        return [
            new ProductAbstractStorePropelWriterPlugin(),
        ];
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createProductAbstractPropelWriter(): DataSetWriterInterface
    {
        return new ProductAbstractPropelDataSetWriter($this->createProductRepository());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createProductConcretePropelWriter(): DataSetWriterInterface
    {
        return new ProductConcretePropelDataSetWriter($this->createProductRepository());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createProductImagePropelWriter(): DataSetWriterInterface
    {
        return new ProductImagePropelDataSetWriter($this->createProductImageRepository());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createProductStockPropelWriter(): DataSetWriterInterface
    {
        return new ProductStockPropelDataSetWriter(
            $this->getProductBundleFacade(),
            $this->createProductRepository(),
            $this->getStoreFacade(),
            $this->getStockFacade()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createProductAbstractStorePropelWriter(): DataSetWriterInterface
    {
        return new ProductAbstractStorePropelDataSetWriter();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository
     */
    protected function createProductRepository()
    {
        return new ProductRepository();
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductAttributeKeyImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep(new ProductAttributeKeyWriter());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductManagementAttributeImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createAddProductAttributeKeysStep())
            ->addStep($this->createProductManagementLocalizedAttributesExtractorStep())
            ->addStep(new ProductManagementAttributeWriter());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductManagementAttribute\ProductManagementLocalizedAttributesExtractorStep
     */
    protected function createProductManagementLocalizedAttributesExtractorStep()
    {
        return new ProductManagementLocalizedAttributesExtractorStep();
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductGroupImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductGroupWriter::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new ProductGroupWriter(
                $this->createProductRepository()
            ));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createAbstractGiftCardConfigurationImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );
        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(GiftCardAbstractConfigurationWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new GiftCardAbstractConfigurationWriterStep($this->createProductRepository()));
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createConcreteGiftCardConfigurationImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );
        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(GiftCardConcreteConfigurationWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new GiftCardConcreteConfigurationWriterStep($this->createProductRepository()));
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductReviewImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep(new ProductReviewWriterStep(
            $this->createProductRepository(),
            $this->createLocaleRepository()
        ));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductSetImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createAddProductAbstractSkusStep())
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createProductSetImageExtractorStep())
            ->addStep($this->createLocalizedAttributesExtractorStep([
                ProductSetWriterStep::KEY_NAME,
                ProductSetWriterStep::KEY_URL,
                ProductSetWriterStep::KEY_DESCRIPTION,
                ProductSetWriterStep::KEY_META_TITLE,
                ProductSetWriterStep::KEY_META_DESCRIPTION,
                ProductSetWriterStep::KEY_META_KEYWORDS,
            ]))
            ->addStep(new ProductSetWriterStep(
                $this->createProductRepository()
            ));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductSet\ProductSetImageExtractorStep
     */
    protected function createProductSetImageExtractorStep()
    {
        return new ProductSetImageExtractorStep();
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductSearchAttributeMapImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createAddProductAttributeKeysStep())
            ->addStep(new ProductSearchAttributeMapWriter());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductSearchAttributeImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createAddProductAttributeKeysStep())
            ->addStep($this->createLocalizedAttributesExtractorStep([ProductSearchAttributeWriter::KEY]))
            ->addStep(new ProductSearchAttributeWriter(
                $this->createSearchGlossaryKeyBuilder()
            ));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->addAfterImportHook($this->createProductSearchAfterImportHook());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductSearchAttribute\Hook\ProductSearchAfterImportHook
     */
    protected function createProductSearchAfterImportHook()
    {
        return new ProductSearchAfterImportHook();
    }

    /**
     * @return \Spryker\Shared\ProductSearch\Code\KeyBuilder\FilterGlossaryKeyBuilder
     */
    protected function createSearchGlossaryKeyBuilder()
    {
        return new FilterGlossaryKeyBuilder();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductAbstract\AddCategoryKeysStep
     */
    protected function createAddCategoryKeysStep()
    {
        return new AddCategoryKeysStep();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\Product\AttributesExtractorStep
     */
    protected function createAttributesExtractorStep()
    {
        return new AttributesExtractorStep();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\Product\AttributesExtractorStep
     */
    protected function createCombinedAttributesExtractorStep()
    {
        return new CombinedAttributesExtractorStep();
    }

    /**
     * @param array $defaultAttributes
     *
     * @return \Pyz\Zed\DataImport\Business\Model\Product\ProductLocalizedAttributesExtractorStep
     */
    protected function createProductLocalizedAttributesExtractorStep(array $defaultAttributes = [])
    {
        return new ProductLocalizedAttributesExtractorStep($defaultAttributes);
    }

    /**
     * @param array $defaultAttributes
     *
     * @return \Pyz\Zed\DataImport\Business\Model\Product\ProductLocalizedAttributesExtractorStep
     */
    protected function createCombinedProductLocalizedAttributesExtractorStep(array $defaultAttributes = [])
    {
        return new CombinedProductLocalizedAttributesExtractorStep($defaultAttributes);
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductAbstract\AddProductAbstractSkusStep
     */
    protected function createAddProductAbstractSkusStep()
    {
        return new AddProductAbstractSkusStep();
    }

    /**
     * @param string $source
     * @param string $target
     *
     * @return \Pyz\Zed\DataImport\Business\Model\Locale\LocaleNameToIdLocaleStep
     */
    protected function createLocaleNameToIdStep($source = LocaleNameToIdLocaleStep::KEY_SOURCE, $target = LocaleNameToIdLocaleStep::KEY_TARGET)
    {
        return new LocaleNameToIdLocaleStep($source, $target);
    }

    /**
     * @param string $source
     * @param string $target
     *
     * @return \Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractSkuToIdProductAbstractStep
     */
    protected function createProductAbstractSkuToIdProductAbstractStep(
        string $source = ProductAbstractSkuToIdProductAbstractStep::KEY_SOURCE,
        string $target = ProductAbstractSkuToIdProductAbstractStep::KEY_TARGET
    ): ProductAbstractSkuToIdProductAbstractStep {
        return new ProductAbstractSkuToIdProductAbstractStep($source, $target);
    }

    /**
     * @param string $source
     * @param string $target
     *
     * @return \Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductSkuToIdProductStep
     */
    protected function createProductSkuToIdProductStep(
        string $source = ProductSkuToIdProductStep::KEY_SOURCE,
        string $target = ProductSkuToIdProductStep::KEY_TARGET
    ): ProductSkuToIdProductStep {
        return new ProductSkuToIdProductStep($source, $target);
    }

    /**
     * @param string $source
     * @param string $target
     *
     * @return \Pyz\Zed\DataImport\Business\Model\Tax\TaxSetNameToIdTaxSetStep
     */
    protected function createTaxSetNameToIdTaxSetStep($source = TaxSetNameToIdTaxSetStep::KEY_SOURCE, $target = TaxSetNameToIdTaxSetStep::KEY_TARGET)
    {
        return new TaxSetNameToIdTaxSetStep($source, $target);
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\AddProductAttributeKeysStep
     */
    protected function createAddProductAttributeKeysStep()
    {
        return new AddProductAttributeKeysStep();
    }

    /**
     * @return \Spryker\Zed\Event\Business\EventFacadeInterface
     */
    protected function getEventFacade()
    {
        return $this->getProvidedDependency(DataImportDependencyProvider::FACADE_EVENT);
    }

    /**
     * @return \Spryker\Zed\Currency\Business\CurrencyFacadeInterface
     */
    protected function getCurrencyFacade(): CurrencyFacadeInterface
    {
        return $this->getProvidedDependency(DataImportDependencyProvider::FACADE_CURRENCY);
    }

    /**
     * @return \Spryker\Zed\PriceProduct\Business\PriceProductFacadeInterface
     */
    public function getPriceProductFacade(): PriceProductFacadeInterface
    {
        return $this->getProvidedDependency(DataImportDependencyProvider::FACADE_PRICE_PRODUCT);
    }

    /**
     * @return \Spryker\Zed\Stock\Business\StockFacadeInterface
     */
    protected function getStockFacade(): StockFacadeInterface
    {
        return $this->getProvidedDependency(DataImportDependencyProvider::FACADE_STOCK);
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(DataImportDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    protected function createAddLocalesStep(): DataImportStepInterface
    {
        return new AddLocalesStep($this->getStore());
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductImage\Repository\ProductImageRepositoryInterface
     */
    public function createProductImageRepository(): ProductImageRepositoryInterface
    {
        return new ProductImageRepository();
    }

    /**
     * @param string $importType
     * @param \Spryker\Zed\DataImport\Business\Model\DataReader\DataReaderInterface $reader
     *
     * @return \Pyz\Zed\DataImport\Business\Model\DataImporterDataSetWriterAwareConditional
     */
    public function createDataImporterWriterAwareConditional($importType, DataReaderInterface $reader)
    {
        return new DataImporterDataSetWriterAwareConditional($importType, $reader);
    }

    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer $dataImporterConfigurationTransfer
     *
     * @return \Pyz\Zed\DataImport\Business\Model\DataImporterConditional
     */
    public function getConditionalCsvDataImporterFromConfig(DataImporterConfigurationTransfer $dataImporterConfigurationTransfer)
    {
        $csvReader = $this->createCsvReaderFromConfig($dataImporterConfigurationTransfer->getReaderConfiguration());

        return $this->createDataImporterConditional($dataImporterConfigurationTransfer->getImportType(), $csvReader);
    }

    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer $dataImporterConfigurationTransfer
     *
     * @return \Pyz\Zed\DataImport\Business\Model\DataImporterDataSetWriterAwareConditional
     */
    public function getConditionalCsvDataImporterWriterAwareFromConfig(DataImporterConfigurationTransfer $dataImporterConfigurationTransfer)
    {
        $csvReader = $this->createCsvReaderFromConfig($dataImporterConfigurationTransfer->getReaderConfiguration());

        return $this->createDataImporterWriterAwareConditional($dataImporterConfigurationTransfer->getImportType(), $csvReader);
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createCombinedProductPricePropelDataSetWriter(): DataSetWriterInterface
    {
        return new CombinedProductPricePropelDataSetWriter(
            $this->createProductRepository(),
            $this->getStoreFacade(),
            $this->getCurrencyFacade()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createCombinedProductImagePropelDataSetWriter(): DataSetWriterInterface
    {
        return new CombinedProductImagePropelDataSetWriter(
            $this->createProductImageRepository()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createCombinedProductStockPropelDataSetWriter(): DataSetWriterInterface
    {
        return new CombinedProductStockPropelDataSetWriter(
            $this->getProductBundleFacade(),
            $this->createProductRepository(),
            $this->getStoreFacade(),
            $this->getStockFacade()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createCombinedProductAbstractStorePropelDataSetWriter(): DataSetWriterInterface
    {
        return new CombinedProductAbstractStorePropelDataSetWriter();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createCombinedProductAbstractPropelDataSetWriter(): DataSetWriterInterface
    {
        return new CombinedProductAbstractPropelDataSetWriter(
            $this->createProductRepository()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    public function createCombinedProductConcretePropelDataSetWriter(): DataSetWriterInterface
    {
        return new CombinedProductConcretePropelDataSetWriter(
            $this->createProductRepository()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createCombinedProductPriceImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getConditionalCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(CombinedProductPriceHydratorStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new CombinedProductPriceHydratorStep(
                $this->getPriceProductFacade(),
                $this->getUtilEncodingService()
            ));

        $dataImporter->setDataSetCondition($this->createCombinedProductPriceMandatoryColumnCondition());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createCombinedProductPriceDataSetWriters());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    protected function createCombinedProductPriceMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedProductPriceMandatoryColumnCondition();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createCombinedProductPriceDataSetWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createCombinedProductPriceDataSetWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createCombinedProductPriceDataSetWriterPlugins(): array
    {
        return [
            new CombinedProductPricePropelWriterPlugin(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createCombinedProductImageImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getConditionalCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(CombinedProductImageHydratorStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createProductAbstractSkuToIdProductAbstractStep(CombinedProductImageHydratorStep::COLUMN_ABSTRACT_SKU, ProductImageHydratorStep::KEY_IMAGE_SET_FK_PRODUCT_ABSTRACT))
            ->addStep($this->createProductSkuToIdProductStep(CombinedProductImageHydratorStep::COLUMN_CONCRETE_SKU, ProductImageHydratorStep::KEY_IMAGE_SET_FK_PRODUCT))
            ->addStep($this->createLocaleNameToIdStep(CombinedProductImageHydratorStep::COLUMN_LOCALE, ProductImageHydratorStep::KEY_IMAGE_SET_FK_LOCALE))
            ->addStep(new CombinedProductImageHydratorStep());

        $dataImporter->setDataSetCondition($this->createCombinedProductImageMandatoryColumnCondition());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createCombinedProductImageDataSetWriters());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    protected function createCombinedProductImageMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedProductImageMandatoryColumnCondition();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createCombinedProductImageDataSetWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createCombinedProductImageDataSetWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createCombinedProductImageDataSetWriterPlugins(): array
    {
        return [
            new CombinedProductImagePropelWriterPlugin(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createCombinedProductStockImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getConditionalCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(CombinedProductStockHydratorStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new CombinedProductStockHydratorStep());

        $dataImporter->setDataSetCondition($this->createCombinedProductStockMandatoryColumnCondition());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createCombinedProductStockDataSetWriters());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    protected function createCombinedProductStockMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedProductStockMandatoryColumnCondition();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createCombinedProductStockDataSetWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createCombinedProductStockDataSetWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createCombinedProductStockDataSetWriterPlugins(): array
    {
        return [
            new CombinedProductStockPropelWriterPlugin(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createCombinedProductAbstractStoreImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getConditionalCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(CombinedProductAbstractStoreHydratorStep::BULK_SIZE);
        $dataSetStepBroker->addStep(new CombinedProductAbstractStoreHydratorStep());

        $dataImporter->setDataSetCondition($this->createCombinedProductAbstractStoreMandatoryColumnCondition());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createCombinedProductAbstractStoreDataSetWriters());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    protected function createCombinedProductAbstractStoreMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedProductAbstractStoreMandatoryColumnCondition();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createCombinedProductAbstractStoreDataSetWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createCombinedProductAbstractStoreDataSetWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createCombinedProductAbstractStoreDataSetWriterPlugins(): array
    {
        return [
            new CombinedProductAbstractStorePropelWriterPlugin(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createCombinedProductAbstractImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getConditionalCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(CombinedProductAbstractHydratorStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createProductAbstractCheckExistenceStep())
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createAddCategoryKeysStep())
            ->addStep($this->createTaxSetNameToIdTaxSetStep(CombinedProductAbstractHydratorStep::COLUMN_TAX_SET_NAME))
            ->addStep($this->createCombinedAttributesExtractorStep())
            ->addStep($this->createCombinedProductLocalizedAttributesExtractorStep([
                CombinedProductAbstractHydratorStep::COLUMN_NAME,
                CombinedProductAbstractHydratorStep::COLUMN_URL,
                CombinedProductAbstractHydratorStep::COLUMN_DESCRIPTION,
                CombinedProductAbstractHydratorStep::COLUMN_META_TITLE,
                CombinedProductAbstractHydratorStep::COLUMN_META_DESCRIPTION,
                CombinedProductAbstractHydratorStep::COLUMN_META_KEYWORDS,
            ]))
            ->addStep(new CombinedProductAbstractHydratorStep());

        $dataImporter->setDataSetCondition($this->createCombinedProductAbstractTypeDataSetCondition());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createCombinedProductAbstractDataSetWriters());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    protected function createCombinedProductAbstractTypeDataSetCondition(): DataSetConditionInterface
    {
        return new CombinedProductAbstractTypeDataSetCondition();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createCombinedProductAbstractDataSetWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createCombinedProductAbstractDataSetWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createCombinedProductAbstractDataSetWriterPlugins(): array
    {
        return [
            new CombinedProductAbstractPropelWriterPlugin(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createCombinedProductConcreteImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getConditionalCsvDataImporterWriterAwareFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(CombinedProductConcreteHydratorStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createProductConcreteCheckExistenceStep())
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createCombinedAttributesExtractorStep())
            ->addStep($this->createProductConcreteAttributesUniqueCheckStep())
            ->addStep($this->createCombinedProductLocalizedAttributesExtractorStep([
                CombinedProductConcreteHydratorStep::COLUMN_NAME,
                CombinedProductConcreteHydratorStep::COLUMN_DESCRIPTION,
                CombinedProductConcreteHydratorStep::COLUMN_IS_SEARCHABLE,
            ]))
            ->addStep(new CombinedProductConcreteHydratorStep(
                $this->createProductRepository()
            ));

        $dataImporter->setDataSetCondition($this->createCombinedProductConcreteTypeDataSetCondition());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->setDataSetWriter($this->createCombinedProductConcreteDataSetWriters());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    protected function createCombinedProductConcreteTypeDataSetCondition(): DataSetConditionInterface
    {
        return new CombinedProductConcreteTypeDataSetCondition();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetWriterInterface
     */
    protected function createCombinedProductConcreteDataSetWriters(): DataSetWriterInterface
    {
        return new DataSetWriterCollection($this->createCombinedProductConcreteDataSetWriterPlugins());
    }

    /**
     * @return \Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface[]
     */
    protected function createCombinedProductConcreteDataSetWriterPlugins(): array
    {
        return [
            new CombinedProductConcretePropelWriterPlugin(),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createCombinedProductGroupImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getConditionalCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductGroupWriter::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new CombinedProductGroupWriter($this->createProductRepository()));

        $dataImporter->setDataSetCondition($this->createCombinedProductGroupMandatoryColumnCondition());
        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\DataSet\DataSetConditionInterface
     */
    protected function createCombinedProductGroupMandatoryColumnCondition(): DataSetConditionInterface
    {
        return new CombinedProductGroupMandatoryColumnCondition();
    }
}
