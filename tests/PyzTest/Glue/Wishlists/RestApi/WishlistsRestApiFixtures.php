<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Glue\Wishlists\RestApi;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\WishlistItemTransfer;
use Generated\Shared\Transfer\WishlistTransfer;
use PyzTest\Glue\Wishlists\WishlistsApiTester;
use SprykerTest\Shared\Testify\Fixtures\FixturesBuilderInterface;
use SprykerTest\Shared\Testify\Fixtures\FixturesContainerInterface;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Glue
 * @group Wishlists
 * @group RestApi
 * @group WishlistsRestApiFixtures
 * Add your own group annotations below this line
 * @group EndToEnd
 */
class WishlistsRestApiFixtures implements FixturesBuilderInterface, FixturesContainerInterface
{
    /**
     * @var string
     */
    protected const TEST_USERNAME = 'UserWishlistsRestApiFixtures';

    /**
     * @var string
     */
    protected const TEST_PASSWORD = 'change123';

    protected WishlistTransfer $wishlistTransfer;

    protected ProductConcreteTransfer $productConcreteTransfer;

    protected CustomerTransfer $customerTransfer;

    public function getProductConcreteTransfer(): ProductConcreteTransfer
    {
        return $this->productConcreteTransfer;
    }

    public function getWishlistTransfer(): WishlistTransfer
    {
        return $this->wishlistTransfer;
    }

    public function getCustomerTransfer(): CustomerTransfer
    {
        return $this->customerTransfer;
    }

    public function buildFixtures(WishlistsApiTester $I): FixturesContainerInterface
    {
        $this->createWishlist($I);

        return $this;
    }

    protected function createWishlist(WishlistsApiTester $I): void
    {
        $this->productConcreteTransfer = $I->haveFullProduct();

        $this->customerTransfer = $I->haveCustomer([
            CustomerTransfer::USERNAME => static::TEST_USERNAME,
            CustomerTransfer::PASSWORD => static::TEST_PASSWORD,
            CustomerTransfer::NEW_PASSWORD => static::TEST_PASSWORD,
        ]);

        $this->customerTransfer = $I->confirmCustomer($this->customerTransfer);

        $this->wishlistTransfer = $I->haveWishlist([
            WishlistTransfer::FK_CUSTOMER => $this->customerTransfer->getIdCustomer(),
        ]);

        $I->haveItemInWishlist([
            WishlistItemTransfer::FK_WISHLIST => $this->wishlistTransfer->getIdWishlist(),
            WishlistItemTransfer::WISHLIST_NAME => $this->wishlistTransfer->getName(),
            WishlistItemTransfer::SKU => $this->productConcreteTransfer->getSku(),
            WishlistItemTransfer::FK_CUSTOMER => $this->customerTransfer->getIdCustomer(),
            WishlistItemTransfer::PRODUCT_OFFER_REFERENCE => null,
            WishlistItemTransfer::MERCHANT_REFERENCE => null,
        ]);
    }
}
