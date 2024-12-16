<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Client\ProductDetailWidget\Stub;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductDataTransfer;
use Generated\Shared\Transfer\ProductResponseTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class ZedStub implements ZedStubInterface
{
    /**
     * @var \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param string $sku
     *
     * @return ProductResponseTransfer
     */
    /**
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ProductResponseTransfer
     */
    public function findProductAbstractBySku(string $sku): ProductResponseTransfer
    {
        // Create a new Transfer object for the request
        $productDataTransfer = new ProductAbstractTransfer();
        $productDataTransfer->setSku($sku);

        // Make the Zed request
        /** @var \Generated\Shared\Transfer\ProductResponseTransfer $productResponseTransfer */
        $productResponseTransfer = $this->zedRequestClient->call('/product-detail/gateway/get-product-detail', $productDataTransfer);

        return $productResponseTransfer;
    }
}
