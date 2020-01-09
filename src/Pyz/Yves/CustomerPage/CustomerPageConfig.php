<?php


namespace Pyz\Yves\CustomerPage;

use Spryker\Shared\Kernel\Store;
use SprykerShop\Yves\CustomerPage\CustomerPageConfig as SprykerCustomerPageConfig;

class CustomerPageConfig extends SprykerCustomerPageConfig
{
    protected const LOGIN_FAILURE_REDIRECT_URL = '/login';

    /**
     * {@inheritDoc}
     *
     * @return string|null
     */
    public function loginFailureRedirectUrl(): ?string
    {
        return static::LOGIN_FAILURE_REDIRECT_URL;
    }

}
