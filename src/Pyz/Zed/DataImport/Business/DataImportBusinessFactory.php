<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business;

use Generated\Shared\Transfer\DataImportConfigurationActionTransfer;
use Pyz\Zed\DataImport\Business\Model\CategoryTemplate\CategoryTemplateWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsBlock\CmsBlockWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsBlockStore\CmsBlockStoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\CmsTemplate\CmsTemplateWriterStep;
use Pyz\Zed\DataImport\Business\Model\Country\Repository\CountryRepository;
use Pyz\Zed\DataImport\Business\Model\Currency\CurrencyWriterStep;
use Pyz\Zed\DataImport\Business\Model\Customer\CustomerWriterStep;
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
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstractStore\ProductAbstractStoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\AddProductAttributeKeysStep;
use Pyz\Zed\DataImport\Business\Model\ProductAttributeKey\ProductAttributeKeyWriter;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteAttributesUniqueCheckStep;
use Pyz\Zed\DataImport\Business\Model\ProductConcrete\ProductConcreteWriter;
use Pyz\Zed\DataImport\Business\Model\ProductGroup\ProductGroupWriter;
use Pyz\Zed\DataImport\Business\Model\ProductImage\ProductImageWriterStep;
use Pyz\Zed\DataImport\Business\Model\ProductLabel\Hook\ProductLabelAfterImportPublishHook;
use Pyz\Zed\DataImport\Business\Model\ProductLabel\ProductLabelWriterStep;
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
use Pyz\Zed\DataImport\Business\Model\ProductStock\ProductStockWriterStep;
use Pyz\Zed\DataImport\Business\Model\Store\StoreReader;
use Pyz\Zed\DataImport\Business\Model\Store\StoreWriterStep;
use Pyz\Zed\DataImport\Business\Model\Tax\TaxSetNameToIdTaxSetStep;
use Pyz\Zed\DataImport\Business\Model\Tax\TaxWriterStep;
use Pyz\Zed\DataImport\DataImportConfig;
use Pyz\Zed\DataImport\DataImportDependencyProvider;
use Spryker\Shared\Kernel\Store;
use Spryker\Shared\ProductSearch\Code\KeyBuilder\FilterGlossaryKeyBuilder;
use Spryker\Zed\DataImport\Business\DataImportBusinessFactory as SprykerDataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\Discount\DiscountConfig;

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
            case DataImportConfig::IMPORT_TYPE_PRODUCT_REVIEW:
                return $this->createProductReviewImporter($dataImportConfigurationActionTransfer);
            case DataImportConfig::IMPORT_TYPE_PRODUCT_LABEL:
                return $this->createProductLabelImporter($dataImportConfigurationActionTransfer);
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
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductStockImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductStockWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new ProductStockWriterStep(
                $this->createProductRepository(),
                $this->getAvailabilityFacade(),
                $this->getProductBundleFacade()
            ));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->addAfterImportHook($this->createProductStockAfterImportPublishHook());

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
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductImageImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductImageWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep(new ProductImageWriterStep(
                $this->createLocaleRepository(),
                $this->createProductRepository()
            ));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

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
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductAbstractImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductAbstractWriterStep::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createAddCategoryKeysStep())
            ->addStep($this->createTaxSetNameToIdTaxSetStep(ProductAbstractWriterStep::KEY_TAX_SET_NAME))
            ->addStep($this->createAttributesExtractorStep())
            ->addStep($this->createProductLocalizedAttributesExtractorStep([
                ProductAbstractWriterStep::KEY_NAME,
                ProductAbstractWriterStep::KEY_URL,
                ProductAbstractWriterStep::KEY_DESCRIPTION,
                ProductAbstractWriterStep::KEY_META_TITLE,
                ProductAbstractWriterStep::KEY_META_DESCRIPTION,
                ProductAbstractWriterStep::KEY_META_KEYWORDS,
            ]))
            ->addStep(new ProductAbstractWriterStep(
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
    protected function createProductAbstractStoreImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductAbstractStoreWriterStep::BULK_SIZE);
        $dataSetStepBroker->addStep(new ProductAbstractStoreWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @param \Generated\Shared\Transfer\DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    protected function createProductConcreteImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker(ProductConcreteWriter::BULK_SIZE);
        $dataSetStepBroker
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createAttributesExtractorStep())
            ->addStep($this->createProductConcreteAttributesUniqueCheckStep())
            ->addStep($this->createProductLocalizedAttributesExtractorStep([
                ProductConcreteWriter::KEY_NAME,
                ProductConcreteWriter::KEY_DESCRIPTION,
                ProductConcreteWriter::KEY_IS_SEARCHABLE,
            ]))
            ->addStep(new ProductConcreteWriter(
                $this->createProductRepository()
            ));

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

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
    protected function createProductLabelImporter(DataImportConfigurationActionTransfer $dataImportConfigurationActionTransfer)
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->buildImporterConfigurationByDataImportConfigAction($dataImportConfigurationActionTransfer)
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker
            ->addStep($this->createAddProductAbstractSkusStep())
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createLocalizedAttributesExtractorStep(['name']))
            ->addStep(new ProductLabelWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);
        $dataImporter->addAfterImportHook($this->createProductLabelAfterImportPublishHook());

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductLabel\Hook\ProductLabelAfterImportPublishHook
     */
    protected function createProductLabelAfterImportPublishHook()
    {
        return new ProductLabelAfterImportPublishHook();
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
     * @param array $defaultAttributes
     *
     * @return \Pyz\Zed\DataImport\Business\Model\Product\ProductLocalizedAttributesExtractorStep
     */
    protected function createProductLocalizedAttributesExtractorStep(array $defaultAttributes = [])
    {
        return new ProductLocalizedAttributesExtractorStep($defaultAttributes);
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
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    protected function createAddLocalesStep(): DataImportStepInterface
    {
        return new AddLocalesStep($this->getStore());
    }
}
