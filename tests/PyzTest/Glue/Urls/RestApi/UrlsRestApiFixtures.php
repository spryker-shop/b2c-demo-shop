<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Urls\RestApi;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductUrlTransfer;
use Generated\Shared\Transfer\UrlTransfer;
use PyzTest\Glue\Urls\UrlsRestApiTester;
use Spryker\Zed\Locale\Business\LocaleFacade;
use Spryker\Zed\Url\Business\UrlFacade;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Urls
 * @group RestApi
 * @group UrlsRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class UrlsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    protected ProductConcreteTransfer $productConcreteTransfer;

    protected ProductUrlTransfer $productUrlTransfer;

    protected UrlTransfer $categoryUrlTransfer;

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function getProductUrlTransfer(): ProductUrlTransfer
    {
        return $this->productUrlTransfer;
    }

    public function buildFixtures(UrlsRestApiTester $I): FixturesContainerInterface
    {
        $this->createProductConcrete($I);
        $this->createProductUrl($I);
        $this->createCategoryUrl($I);

        return $this;
    }

    protected function createProductConcrete(UrlsRestApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();
    }

    protected function createProductUrl(UrlsRestApiTester $I): void
    {
        $productAbstractTransfer = (new ProductAbstractTransfer())
            ->setIdProductAbstract($this->productConcreteTransfer->getFkProductAbstract());

        $this->productUrlTransfer = $I->getProductFacade()->getProductUrl($productAbstractTransfer);
    }

    protected function createCategoryUrl(UrlsRestApiTester $I): void
    {
        $categoryTransfer = $I->haveLocalizedCategory();

        $storeTransfer = $I->getLocator()->store()->facade()->getCurrentStore();

        $I->haveCategoryStoreRelation(
            $categoryTransfer->getIdCategory(),
            $storeTransfer->getIdStore(),
        );

        $this->categoryUrlTransfer = (new UrlFacade())
            ->getResourceUrlByCategoryNodeIdAndLocale(
                $categoryTransfer->getCategoryNode()->getIdCategoryNode(),
                (new LocaleFacade())->getCurrentLocale(),
            );
    }
}
