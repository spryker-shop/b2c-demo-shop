<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductReviewWidget;

use Pyz\Yves\ProductReviewWidget\Form\ProductReviewForm;
use Spryker\Shared\Application\ApplicationConstants;
use SprykerShop\Yves\ProductReviewWidget\Controller\Calculator\ProductReviewSummaryCalculator;
use SprykerShop\Yves\ProductReviewWidget\Dependency\Client\ProductReviewWidgetToCustomerClientInterface;
use SprykerShop\Yves\ProductReviewWidget\Dependency\Client\ProductReviewWidgetToProductReviewClientInterface;
use SprykerShop\Yves\ProductReviewWidget\Dependency\Client\ProductReviewWidgetToProductReviewStorageClientInterface;
use SprykerShop\Yves\ProductReviewWidget\Form\DataProvider\ProductReviewFormDataProvider;
use SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetDependencyProvider;
use SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetFactory as SprykerShopProductReviewWidgetFactory;

class ProductReviewWidgetFactory extends SprykerShopProductReviewWidgetFactory
{
    /**
     * @return \SprykerShop\Yves\ProductReviewWidget\Dependency\Client\ProductReviewWidgetToCustomerClientInterface
     */
    public function getCustomerClient(): ProductReviewWidgetToCustomerClientInterface
    {
        return $this->getProvidedDependency(ProductReviewWidgetDependencyProvider::CLIENT_CUSTOMER);
    }

    /**
     * @return \SprykerShop\Yves\ProductReviewWidget\Dependency\Client\ProductReviewWidgetToProductReviewClientInterface
     */
    public function getProductReviewClient(): ProductReviewWidgetToProductReviewClientInterface
    {
        return $this->getProvidedDependency(ProductReviewWidgetDependencyProvider::CLIENT_PRODUCT_REVIEW);
    }

    /**
     * @return \SprykerShop\Yves\ProductReviewWidget\Dependency\Client\ProductReviewWidgetToProductReviewStorageClientInterface
     */
    public function getProductReviewStorageClient(): ProductReviewWidgetToProductReviewStorageClientInterface
    {
        return $this->getProvidedDependency(ProductReviewWidgetDependencyProvider::CLIENT_PRODUCT_REVIEW_STORAGE);
    }

    /**
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormFactory()
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

    /**
     * @param int $idProductAbstract
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createProductReviewForm($idProductAbstract)
    {
        $dataProvider = $this->createProductReviewFormDataProvider();
        $form = $this->getFormFactory()->create(
            ProductReviewForm::class,
            $dataProvider->getData($idProductAbstract),
            $dataProvider->getOptions()
        );

        return $form;
    }

    /**
     * @return \SprykerShop\Yves\ProductReviewWidget\Controller\Calculator\ProductReviewSummaryCalculatorInterface
     */
    public function createProductReviewSummaryCalculator()
    {
        return new ProductReviewSummaryCalculator($this->getProductReviewClient());
    }

    /**
     * @return \SprykerShop\Yves\ProductReviewWidget\Form\DataProvider\ProductReviewFormDataProvider
     */
    public function createProductReviewFormDataProvider()
    {
        return new ProductReviewFormDataProvider();
    }
}
