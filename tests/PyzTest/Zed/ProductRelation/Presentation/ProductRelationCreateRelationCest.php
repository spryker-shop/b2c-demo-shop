<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\ProductRelation\Presentation;

use PyzTest\Zed\ProductRelation\PageObject\ProductRelationCreatePage;
use PyzTest\Zed\ProductRelation\ProductRelationPresentationTester;
use Spryker\Shared\ProductRelation\ProductRelationTypes;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group ProductRelation
 * @group Presentation
 * @group ProductRelationCreateRelationCest
 * Add your own group annotations below this line
 */
class ProductRelationCreateRelationCest
{
    /**
     * @var string
     */
    protected const PRODUCT_ABSTRACT_SKU = '214';

    /**
     * @param \PyzTest\Zed\ProductRelation\ProductRelationPresentationTester $i
     *
     * @return void
     */
    public function testICanCreateProductRelationAndSeeInYves(ProductRelationPresentationTester $i): void
    {
        $productRelationKey = uniqid('key-');
        $i->cleanupProductRelationEntities(static::PRODUCT_ABSTRACT_SKU);

        $i->wantTo('I want to create up selling relation');
        $i->expect('relation is persisted, exported to yves and carousel component is visible');

        $i->amOnPage(ProductRelationCreatePage::URL);

        $i->waitForElement('//*[@id="product_relation_productRelationKey"]');
        $i->fillField('//*[@id="product_relation_productRelationKey"]', $productRelationKey);
        $i->selectRelationType(ProductRelationTypes::TYPE_RELATED_PRODUCTS);
        $i->filterProductsByName('Samsung Bundle');
        $i->selectProduct(static::PRODUCT_ABSTRACT_SKU);

        $i->switchToAssignProductsTab();

        $i->selectProductRule('product_sku', 'equal', '123');

        $i->clickSaveButton();

        $i->checkProductRelationWasCreated($productRelationKey);
    }
}
