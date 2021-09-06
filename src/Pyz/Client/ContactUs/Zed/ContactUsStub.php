<?php

namespace Pyz\Client\ContactUs\Zed;

use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class ContactUsStub extends ZedRequestStub implements ContactUsStubInterface
{
    /**
     * @var ZedRequestClientInterface
     */
    protected $zedRequestClient;

    /**
     * ContactUsStub constructor.
     *
     * @param ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param ContactUsTransfer $contactUsTransfer
     *
     * @return ContactUsTransfer
     */
    public function saveContact(ContactUsTransfer $contactUsTransfer): ContactUsTransfer
    {
        /** @var \Generated\Shared\Transfer\ContactUsTransfer $contactUsTransfer */
        $contactUsTransfer = $this->zedRequestClient->call('/contact-us/gateway/save-contact',$contactUsTransfer);

        return $contactUsTransfer;
    }
}
