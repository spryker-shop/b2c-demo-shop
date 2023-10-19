<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\ProductReviewWidget;

use Pyz\Yves\ProductReviewWidget\Form\ProductReviewForm;
use Spryker\Client\GlossaryStorage\GlossaryStorageClient;
use SprykerShop\Yves\ProductReviewWidget\ProductReviewWidgetFactory as SprykerShopProductReviewWidgetFactory;
use Symfony\Component\Form\FormInterface;

class ProductReviewWidgetFactory extends SprykerShopProductReviewWidgetFactory
{
    /**
     * @param int $idProductAbstract
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createProductReviewForm($idProductAbstract): FormInterface
    {
        $dataProvider = $this->createProductReviewFormDataProvider();
        $form = $this->getFormFactory()->create(
            ProductReviewForm::class,
            $dataProvider->getData($idProductAbstract),
            $dataProvider->getOptions(),
        );

        return $form;
    }

    /**
     * @return \Spryker\Client\GlossaryStorage\GlossaryStorageClient
     */
    public function getGlossaryClient(): GlossaryStorageClient
    {
        return $this->getProvidedDependency(ProductReviewWidgetDependencyProvider::CLIENT_GLOSSARY_STORAGE);
    }
}
