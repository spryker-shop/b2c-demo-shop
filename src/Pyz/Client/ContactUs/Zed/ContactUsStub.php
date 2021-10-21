<?php

namespace Pyz\Client\ContactUs\Zed;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class ContactUsStub extends ZedRequestStub implements ContactUsStubInterface
{
    /**
     * @param ContactUsTransfer $contactUsTransfer
     */
    public function saveContactUs(ContactUsTransfer $contactUsTransfer)
    {
        $this->zedStub->call('/contact-us/gateway/store', $contactUsTransfer);
    }
}
