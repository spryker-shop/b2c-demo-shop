<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\ProductAttributeGui\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\ProductAttributeGui\Communication\Form\AttributeCsrfForm;
use Spryker\Zed\ProductAttributeGui\Communication\Form\AttributeForm;
use Spryker\Zed\ProductAttributeGui\Communication\Form\AttributeKeyForm;
use Spryker\Zed\ProductAttributeGui\Communication\Form\AttributeKeyFormDataProvider;
use Spryker\Zed\ProductAttributeGui\Communication\Form\AttributeTranslationCollectionForm;
use Spryker\Zed\ProductAttributeGui\Communication\Form\DataProvider\AttributeFormDataProvider;
use Spryker\Zed\ProductAttributeGui\Communication\Form\DataProvider\AttributeTranslationFormCollectionDataProvider;
use Spryker\Zed\ProductAttributeGui\Communication\Table\AttributeTable;
use Spryker\Zed\ProductAttributeGui\Communication\Transfer\AttributeFormTransferMapper;
use Spryker\Zed\ProductAttributeGui\Communication\Transfer\AttributeTranslationFormTransferMapper;
use Pyz\Zed\ProductAttributeGui\ProductAttributeGuiDependencyProvider;
use Spryker\Zed\ProductAttributeGui\Communication\ProductAttributeGuiCommunicationFactory as SpyFactory;

/**
 * @method \Spryker\Zed\ProductAttributeGui\ProductAttributeGuiConfig getConfig()
 */
class ProductAttributeGuiCommunicationFactory extends SpyFactory
{

    /**
     * @return \Pyz\Zed\ProductAttributeGui\Dependency\Facade\ProductAttributeGuiToProductInterface
     */
    public function getProductFacade()
    {
        return $this->getProvidedDependency(ProductAttributeGuiDependencyProvider::FACADE_PRODUCT);
    }
}
